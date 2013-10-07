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
 * This is an interface used by the index to store the information persistently 
 * and retrieve it when needed.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/Interfaces
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
interface IDataDriver
{

    /**
     * Creates a new table in this driver. This should not be completed before a call to {@link commit}.
     * @param ITable $table The table to add.
     */
    function createTable(ITable $table);

    /**
     * Removes a table from this driver. This should not be completed before a call to {@link commit}.
     * @param string|ITable $name The table name to remove, or a table with the same name.
     */
    function dropTable($name);

    /**
     * Gets a table from the driver.
     * @param string $name The name of the table.
     * @return ITable The table.
     * @throws \OutOfBoundsException If the name is not an existing table.
     */
    function &getTable($name);

    /**
     * Commits the pending operations to the persistent database.
     * @return bool Whether the operation was sucessful or not.
     */
    function commit();

    /**
     * Cancel the pending operations.
     */
    function rollBack();

    /**
     * Inserts a new row into the table.
     * @param string|ITable $table The table to perform the action.
     * @param IRow $row The row to insert. The id should be generated if not set
     *        or if it already exists.
     * @return bool Whether or not the row was inserted.
     */
    function insert($table, IRow &$row);

    /**
     * This updates any row that matches the condition with new values.
     * @param string|ITable $table The table to perform the action.
     * @param ICondition $condition The condition to match updateable rows.
     * @param IRow $new_data The new values to insert. Only the fields set will be updated.
     * @return int The number of updated rows.
     */
    function update($table, ICondition $condition, IRow $new_data);

    /**
     * Gets the rows matching a conditons.
     * @param string|ITable $table The table to perform the action.
     * @param ICondition $condition The condition to match.
     * @return IRowCollection A collection of rows, which might be empty.
     */
    function retrieve($table, ICondition $condition);

    /**
     * Deletes the rows matching a condition.
     * @param string|ITable $table The table to perform the action.
     * @param ICondition $condition The condition to match.
     * @return int The number of deleted rows.
     */
    function delete($table, ICondition $condition);
}