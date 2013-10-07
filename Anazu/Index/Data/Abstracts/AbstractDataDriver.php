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

namespace Anazu\Index\Data\Abstracts;

use Anazu\Index\Data\Interfaces\ICondition;
use Anazu\Index\Data\Interfaces\IDataDriver;
use Anazu\Index\Data\Interfaces\IRow;
use Anazu\Index\Data\Interfaces\ITable;

/**
 * An abstract data driver to provide default implementations.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/Abstracts
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
abstract class AbstractDataDriver implements IDataDriver
{

    /**
     * Create table operation.
     */
    const OP_CREATE_TABLE = 1;

    /**
     * Drop table operation.
     */
    const OP_DROP_TABLE = 2;

    /**
     * Insert operation.
     */
    const OP_INSERT = 4;

    /**
     * Retrieve operation.
     */
    const OP_RETRIEVE = 8;

    /**
     * Update operation.
     */
    const OP_UPDATE = 16;

    /**
     * Delete operation.
     */
    const OP_DELETE = 32;

    /**
     * Stores the operations in queue to be commited.
     * @var array Stores the operations in queue to be commited.
     */
    protected $operations = array();

    /**
     * Creates a new table in this driver. This should not be completed before a call to {@link commit}.
     * @param ITable $table The table to add.
     */
    public function createTable(ITable $table)
    {
        $this->operations[] = array(
            self::OP_CREATE_TABLE,
            $table,
        );
    }

    /**
     * Removes a table from this driver. This should not be completed before a call to {@link commit}.
     * @param string|ITable $name The table name to remove, or a table with the same name.
     * @throws \InvalidArgumentException If the table is not valid.
     */
    public function dropTable($name)
    {
        if ( !is_string($name) && !($name instanceof ITable) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either %s or %s. %s given.'
                    , 'name', 'a string', 'an ITable', gettype($name))
            );
        }
        if ( $name instanceof ITable )
        {
            $name = $name->getName();
        }
        $this->operations[] = array(
            self::OP_DROP_TABLE,
            $name
        );
    }

    /**
     * Inserts a new row into the table.
     * @param string|ITable $table The table to perform the action.
     * @param IRow $row The row to insert. The id should be generated if not set
     *        or if it already exists.
     * @return bool Whether or not the row was inserted.
     * @throws \InvalidArgumentException If the table is not valid.
     */
    public function insert($table, IRow &$row)
    {
        if ( !is_string($table) && !($table instanceof ITable) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either %s or %s. %s given.'
                    , 'table', 'a string', 'an ITable', gettype($table))
            );
        }
        if ( $table instanceof ITable )
        {
            $table = $table->getName();
        }
        $this->operations[] = array(
            self::OP_INSERT,
            $table,
            $row
        );
    }

    /**
     * This updates any row that matches the condition with new values.
     * @param string|ITable $table The table to perform the action.
     * @param ICondition $condition The condition to match updateable rows.
     * @param IRow $new_data The new values to insert. Only the fields set will be updated.
     * @return int The number of updated rows.
     * @throws \InvalidArgumentException If the table is not valid.
     */
    public function update($table, ICondition $condition, IRow $new_data)
    {
        if ( !is_string($table) && !($table instanceof ITable) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either %s or %s. %s given.'
                    , 'table', 'a string', 'an ITable', gettype($table))
            );
        }
        if ( $table instanceof ITable )
        {
            $table = $table->getName();
        }
        $this->operations[] = array(
            self::OP_UPDATE,
            $table,
            $condition,
            $new_data
        );
    }

    /**
     * Deletes the rows matching a condition.
     * @param string|ITable $table The table to perform the action.
     * @param ICondition $condition The condition to match.
     * @return int The number of deleted rows.
     * @throws \InvalidArgumentException If the table is not valid.
     */
    public function delete($table, ICondition $condition)
    {
        if ( !is_string($table) && !($table instanceof ITable) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either %s or %s. %s given.'
                    , 'table', 'a string', 'an ITable', gettype($table))
            );
        }
        if ( $table instanceof ITable )
        {
            $table = $table->getName();
        }
        $this->operations[] = array(
            self::OP_DELETE,
            $table,
            $condition
        );
    }

    /**
     * Gets a list of pending operations.
     * @return array The list of operations.
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * Cancel the pending operations.
     */
    public function rollBack()
    {
        $this->operations = array();
    }
}
