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
 * Abstract class for a table of data, like a database table.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/Abstracts
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
abstract class AbstractTable implements ITable
{

    /**
     * The name of this table.
     * @var string The name of this table.
     */
    protected $name;
    /**
     * The driver for persisting data.
     * @var IDataDriver The driver for persisting data.
     */
    protected $driver;
    /**
     * The columns of this table.
     * @var array The columns of this table.
     */
    protected $columns;
    /**
     * Inserts a new row into the table.
     * @param IRow $row The row to insert. The id should be generated if not set
     *        or if it already exists.
     * @return bool Whether or not the row was inserted.
     */
    public function insert(IRow &$row)
    {
        return $this->driver->insert($this, $row);
    }

    /**
     * This updates any row that matches the condition with new values.
     * 
     * @param ICondition $condition The condition to match updateable rows.
     * @param IRow $new_data The new values to insert. Only the fields set will be updated.
     * @return int The number of updated rows.
     */
    public function update(ICondition $condition, IRow $new_data)
    {
        return $this->driver->update($this, $condition, $new_data);
    }

    /**
     * Gets the rows matching a conditons.
     * @param ICondition $condition The condition to match.
     * @return IRowCollection A collection of rows, which might be empty.
     */
    public function retrieve(ICondition $condition)
    {
        return $this->driver->retrieve($this, $condition);
    }

    /**
     * Deletes the rows matching a condition.
     * @param ICondition $condition The condition to match.
     * @return int The number of deleted rows.
     */
    public function delete(ICondition $condition)
    {
        return $this->driver->delete($this, $condition);
    }

    /**
     * Gets an array of all columns in this table.
     * @return array The columns collection.
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Gets the name of this table.
     * @return string The name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the driver to be used in this table.
     * @param IDataDriver $driver The driver to be set to.
     */
    public function setDriver(IDataDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Gets the driver used in this table.
     * @return IDataDriver The driver being used.
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Creates a new table.
     * @param string $name The name of this table.
     * @param array $columns The columns of this table.
     * @param \Anazu\Index\Data\Interfaces\IDataDriver $driver The driver to persist the data.
     * @throws \InvalidArgumentException If the name is not a string.
     */
    public function __construct($name, array $columns, IDataDriver $driver = NULL)
    {
        if ( !is_string($name) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be %s. %s given.'
                    , 'name', 'a string', gettype($name))
            );
        }
        array_walk($columns, function($elem)
        {
            if (!($elem instanceof \Anazu\Index\Data\Interfaces\IColumn))
            {
                throw new \InvalidArgumentException(sprintf(
                        'Argument %s must contain only %s. %s found.', 'columns', 'IColumn', gettype($elem)
                ));
            }
        });
        
        $this->driver = $driver;
        $this->name = $name;
        $this->columns = $columns;
    }

}
