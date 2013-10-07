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

namespace Anazu\Index\Data\Interfaces;

/**
 * Interface a table of data, like a database table.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/Interfaces
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
interface ITable
{
    /**
     * Inserts a new row into the table.
     * @param IRow $row The row to insert. The id should be generated if not set
     *        or if it already exists.
     * @return bool Whether or not the row was inserted.
     */
    function insert(IRow &$row);
    /**
     * This updates any row that matches the condition with new values.
     * 
     * @param ICondition $condition The condition to match updateable rows.
     * @param IRow $new_data The new values to insert. Only the fields set will be updated.
     * @return int The number of updated rows.
     */
    function update(ICondition $condition, IRow $new_data);
    /**
     * Gets the rows matching a conditons.
     * @param ICondition $condition The condition to match.
     * @return IRowCollection A collection of rows, which might be empty.
     */
    function retrieve(ICondition $condition);
    /**
     * Deletes the rows matching a condition.
     * @param ICondition $condition The condition to match.
     * @return int The number of deleted rows.
     */
    function delete(ICondition $condition);
    /**
     * Gets an array of all columns in this table.
     * @return array The columns collection.
     */
    function getColumns();
    /**
     * Gets the name of this table.
     * @return string The name.
     */
    function getName();
    /**
     * Sets the driver to be used in this table.
     * @param IDataDriver $driver The driver to be set to.
     */
    function setDriver(IDataDriver $driver);
    /**
     * Gets the driver used in this table.
     * @return IDataDriver The driver being used.
     */
    function getDriver();
}
