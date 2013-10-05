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
 * Interface for a single register in a table.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/Interfaces
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
interface IRow
{
    /**
     * Gets the identification key of this row.
     * 
     * @return string|int The id key.
     */
    function getId();
    /**
     * Sets the value of a field.
     * @param string $field The name of the field to set.
     * @param mixed $value The value to be set to.
     */
    function setField($field, $value);
    /**
     * Gets the value of a field.
     * @param string $field The name of the field to get.
     * @return mixed The value of such field.
     * @throws \OutOfBoundsException
     */
    function getField($field);
}
