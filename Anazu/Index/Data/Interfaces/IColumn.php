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
 * Interface for a column in a table.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/Interfaces
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
interface IColumn
{
    /**
     * Gets the name of the column.
     * @return string The name.
     */
    function getName();
    /**
     * Gets the type information about this column.
     * @return IValueType The type.
     */
    function getType();
    /**
     * Gets the type of index for this column, such as "Primary" or "unique".
     * @return string The index type.
     */
    function getIndex();
    /**
     * Gets the default value for this column.
     * @return mixed The default value.
     */
    function getDefaultValue();
}
