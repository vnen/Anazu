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
    public function createTable(ITable $table);
    /**
     * Removes a table from this driver. This should not be completed before a call to {@link commit}.
     * @param string|ITable $name The table name to remove, or a table with the same name.
     */
    public function dropTable($name);
    /**
     * Gets a table from the driver.
     * @param string $name The name of the table.
     * @return ITable The table.
     * @throws \OutOfBoundsException If the name is not an existing table.
     */
    public function &getTable($name);
    /**
     * Commits the pending operations to the persistent database.
     * @return bool Whether the operation was sucessful or not.
     */
    public function commit();
    
}
