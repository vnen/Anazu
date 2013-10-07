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
     * Gets a table from the driver.
     * @param string $name The name of the table.
     * @return Interfaces\ITable The table.
     * @throws \OutOfBoundsException If the name is not an existing table.
     */
    public function &getTable($name)
    {
        
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
     */
    public function getTypeForDriver($object)
    {
        
    }
    
}
