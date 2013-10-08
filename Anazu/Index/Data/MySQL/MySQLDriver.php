<?php

/*
 * Copyright (C) 2013 George Marques <george at georgemarques.com.br>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace Anazu\Index\Data\MySQL;

use Anazu\Index\Data\Abstracts;
use Anazu\Index\Data\Interfaces;
use Anazu\Index\Data\RowCollection;

/**
 * Driver that connects to a MySQL database.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/MySQL
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class MySQLDriver extends Abstracts\AbstractDataDriver
{

    /**
     * The pdo connection.
     * @var \PDO The pdo connection.
     */
    protected $connection;

    /**
     * Gets a table from the driver.
     * @param string|Interfaces\ITable $name The name of the table or a table with the same name.
     * @return Interfaces\ITable The table.
     * @throws \OutOfBoundsException If the name is not an existing table.
     */
    public function &getTable($name)
    {
        if ( !is_string($name) && !($name instanceof Interfaces\ITable) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either %s or %s. %s given.'
                    , 'name', 'a string', 'an ITable', gettype($name))
            );
        }

        if ( $name instanceof Interfaces\ITable )
        {
            $name = $name->getName();
        }
        $escName = $this->escapeField($name);

        $query = $this->connection
                ->query("SHOW COLUMNS FROM $escName;");

        if ( !$query )
        {
            throw new \OutOfBoundsException(
            sprintf('The %s "%s" was not found in this %s.', 'table', $name, 'database')
            );
        }

        $tableDesc = $query->fetchAll(\PDO::FETCH_ASSOC);

        $indexes = $this->connection
                ->query("SHOW INDEX FROM $escName;")
                ->fetchAll(\PDO::FETCH_ASSOC);


        $columns = array();
        foreach ($tableDesc as $column)
        {
            $index = $this->grabIndexFromColumn($column['Field'], $indexes);
            $columns[] = new MySQLColumn(
                    $column['Field']
                    , $this->grabType($column['Type'])
                    , $column['Default']
                    , $index ? $this->grabIndex($index) : NULL
            );
        }
        $name = new MySQLTable($name, $columns, $this);
        return $name;
    }

    /**
     * This function parses a type returned from a MySQL descripton
     * and creates a valid MySQLValueType from it.
     * @param string $type The description of the type.
     * @return MySQLValueType The type as object.
     */
    protected function grabType($type)
    {
        $matches = array();
        preg_match('/(?<type>[\w]+)(?:.*?\((?<size>[^)]+))?/', $type, $matches);

        $size = array_key_exists('size', $matches) ? $matches['size'] : NULL;
        return new MySQLValueType($matches['type'], $size);
    }

    /**
     * Gets the index type from the index description.
     * @param array $index An row from a SHOW INDEX result.
     * @return string The index type.
     */
    protected function grabIndex($index)
    {
        if ( $index['Key_name'] == 'PRIMARY' )
        {
            return 'PRIMARY';
        }
        if ( $index['Index_type'] == 'FULLTEXT' )
        {
            return 'FULLTEXT';
        }
        if ( $index['Non_unique'] == '0' )
        {
            return 'UNIQUE';
        }
        return 'INDEX';
    }

    /**
     * For a given column, check if there are an index for it and return it.
     * If there's none, it returns NULL;
     * @param string $column The column name.
     * @param array $indexes The result from a SHOW INDEX.
     */
    protected function grabIndexFromColumn($column, $indexes)
    {
        foreach ($indexes as $index)
        {
            if ( $index['Column_name'] == $column && $index['Seq_in_index'] == '1' )
            {
                return $index;
            }
        }
        return NULL;
    }

    /**
     * Commits the pending operations to the persistent database.
     * @return bool Whether the operation was sucessful or not.
     */
    public function commit()
    {
        
    }

    /**
     * Gets the rows matching a conditons.
     * @param string|Interfaces\ITable $table The table to perform the action.
     * @param Interfaces\ICondition $condition The condition to match.
     * @return Interfaces\IRowCollection A collection of rows, which might be empty.
     */
    public function retrieve($table, Interfaces\ICondition $condition)
    {
        if ( !is_string($table) && !($table instanceof Interfaces\ITable) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either %s or %s. %s given.'
                    , 'table', 'a string', 'an ITable', gettype($table))
            );
        }

        if ( is_string($table) )
        {
            $table = $this->getTable($table);
        }

        $tableName = $this->escapeField($table->getName());
        list($where, $values) = $this->buildCondition($condition);
        
        $stmt = $this->connection->prepare("SELECT * FROM $tableName WHERE $where");
        $fetch = $stmt->execute($values);

        if(!$fetch)
        {
            throw new \Exception('Unknown database error.');
        }
        
        // @codeCoverageIgnoreStart
        $result = array();
        // @codeCoverageIgnoreEnd
        
        while($row = $stmt->fetch(\PDO::FETCH_ASSOC))
        {
            $id = $row['id'];
            unset($row['id']);
            $result[] = new MySQLRow($id, $row);
        }
        
        return new RowCollection($result);
    }

    /**
     * Creates a valid MySQL WHERE clause based on a condition.
     * It doens't guarantee a valid statement if the original condition
     * is malformed.
     * @param MySQLCondition $condition
     * @return string The formed statement.
     * @throws \InvalidArgumentException
     */
    protected function buildCondition(MySQLCondition $condition)
    {
        $list = $condition->getConditionsList();
        if ( empty($list) )
        {
            return array('1', array());
        }
        $where = '';
        $values = array();
        $previousCond = NULL;
        $valueCount = 0;
        foreach ($list as $cond)
        {
            if ( $cond[0] == MySQLCondition::OPEN_PAREN )
            {
                $where .='(';
            }
            if ( $cond[0] == MySQLCondition::CLOSE_PAREN )
            {
                $where .=')';
            }
            if ( $cond[0] == MySQLCondition::AND_COND  || $cond[0] == MySQLCondition::OR_COND)
            {
                if ( $previousCond && $previousCond != MySQLCondition::OPEN_PAREN )
                {
                    $where .= ' '. $cond[0]  .' ';
                }
                list($stmt, $thisValues) = $this->buildConditionOperator($cond[1], $cond[2], $cond[3], $valueCount);
                $where .= $stmt;
                $values = array_merge($values, $thisValues);
            }

            $previousCond = $cond[0];
        }

        return array($where, $values);
    }

    /**
     * Build a single comparison clause being aware of the operator.
     * @param string $field The name of the field.
     * @param string $operator The operator.
     * @param mixed $value The value(s) to compare.
     * @param string $valueCount The counting for prepared statement variables.
     * @return string The formed comparison.
     * @throws Exceptions\BadConditionException If some operator does not have enough arguments.
     */
    protected function buildConditionOperator($field, $operator, $value, &$valueCount)
    {
        $initialCount = $valueCount;
        switch ($operator)
        {
            case '=':
            case '!=':
            case '>':
            case '<':
            case '<>':
            case '<=>':
            case '<=':
            case '>=':
            case 'LIKE':
            case 'NOT LIKE':
            case 'IS':
            case 'IS NOT':
                if ( is_array($value) )
                {
                    throw new Exceptions\BadConditionException('Binary operators do not accept arrays as argument.');
                }
                $stmt = $this->escapeField($field) . " $operator :value" . $valueCount++;
                $values = array(':value' . $initialCount++ => $value);
                return array($stmt, $values);

            case 'BETWEEN':
            case 'NOT BETWEEN':
                if ( !is_array($value) || count($value) != 2 )
                {
                    throw new Exceptions\BadConditionException('This operator requires exactly 2 arguments.');
                }
                $stmt = $this->escapeField($field) . " $operator :value" . $valueCount++ . ' AND :value' . $valueCount++;
                $values = array(
                    ':value' . $initialCount++ => $value[0],
                    ':value' . $initialCount++ => $value[1],
                );
                return array($stmt, $values);

            case 'STRCMP':
                if ( !is_array($value) || count($value) != 2 )
                {
                    throw new Exceptions\BadConditionException('This operator requires exactly 2 arguments.');
                }
                $stmt = 'STRCMP(:value' . $valueCount++ . ',:value' . $valueCount++ . ')';
                $values = array(
                    ':value' . $initialCount++ => "$value[0]",
                    ':value' . $initialCount++ => "$value[1]",
                );
                return array($stmt, $values);

            case 'ISNULL':
                $stmt = 'ISNULL(' . $this->escapeField($field) . ')';
                $values = array();
                return array($stmt, $values);

            case 'IS NULL':
            case 'IS NOT NULL':
                $stmt = $this->escapeField($field) . " $operator";
                $values = array();
                return array($stmt, $values);

            case 'GREATEST':
            case 'LEAST':
            case 'INTERVAL':
                if ( !is_array($value) )
                {
                    throw new Exceptions\BadConditionException('This function needs to receive array as parameter.');
                }
                $field = $this->escapeField($field);
                $stmt = "$operator (" . $field . ($field ? ',' : '');
                $list = array();
                for( ; $valueCount < $initialCount + count($value); $valueCount++)
                {
                    $list[] = ":value$valueCount";
                }
                $stmt .= implode(',', $list) . ')';
                $values = array_combine($list, $value);
                return array($stmt, $values);
                
            case 'IN':
            case 'NOT IN':
                if ( !is_array($value) )
                {
                    throw new Exceptions\BadConditionException('This function needs to receive array as parameter.');
                }
                $stmt = $this->escapeField($field) . " $operator (";
                $list = array();
                for( ; $valueCount < $initialCount + count($value); $valueCount++)
                {
                    $list[] = ":value$valueCount";
                }
                $stmt .= implode(',', $list) . ')';
                $values = array_combine($list, $value);
                return array($stmt, $values);
                
            // @codeCoverageIgnoreStart
            default:
                throw new Exceptions\BadConditionException('Unknown operation.');
        }
            // @codeCoverageIgnoreEnd
    }

    /**
     * This escapes a field or table name.
     * @param string $field The field or table name.
     * @return string The escaped string.
     */
    protected function escapeField($field)
    {
        if(empty($field))
        {
            // @codeCoverageIgnoreStart
            return '';
            // @codeCoverageIgnoreEnd
        }
        $parts = explode('.', $field);
        $result = array_reduce($parts, function($set, $elem)
        {
            return $set .= '`' . str_replace('`', '``', $elem) . '`.';
        });
        return substr($result, 0, -1);
    }

    /**
     * Gets the specific concrete type for data interfaces.
     * For example, if you want the concrete class for a table
     * in this driver, you call this function with the parameter
     * $object = 'ITable'. If you want a condition, call with
     * $object = 'ICondition' and so on.
     * 
     * @param string $object The interface to ask.
     * @return string The full qualified name of the concrete class.
     * @throws \InvalidArgumentException If the parameter is not a string.
     * @throws \OutOfBoundsException If the interface is not existent.
     */
    public function getTypeForDriver($object)
    {
        if ( !is_string($object) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be %s. %s given.'
                    , 'object', 'a string', gettype($object))
            );
        }

        switch ($object)
        {
            case 'ICondition':
                return '\Anazu\Index\Data\MySQL\MySQLCondition';
            case 'IRow':
                return '\Anazu\Index\Data\MySQL\MySQLRow';
            case 'ITable':
                return '\Anazu\Index\Data\MySQL\MySQLTable';
            case 'IColumn':
                return '\Anazu\Index\Data\MySQL\MySQLColumn';
            case 'IValueType':
                return '\Anazu\Index\Data\MySQL\MySQLValueType';
            default:
                throw new \OutOfBoundsException(
                sprintf('The %s "%s" was not found in this %s.', 'interface', $object, 'driver')
                );
        }
    }

    /**
     * Creates a new driver for MySQL.
     * @param string $host The server (e.g. "localhost").
     * @param string $user The user to login.
     * @param string $password The user password.
     * @param string $database The name of the database to use.
     */
    public function __construct($host, $user, $password, $database)
    {
        $this->connection = new \PDO("mysql:host=$host;dbname=$database", $user, $password
                , array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
    }

}
