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
 * A condition for a search in the table. It supports multiple search conditions stacked together in only one object.
 * The functions in this interface should make difference of the order in which they are called.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/Interfaces
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
interface ICondition
{
    /**
     * Sets a condition for a field that will be ANDed with the others.
     * 
     * @param string $field The field to condition.
     * @param string $operator The operation to use. This varies based on the table implementation.
     * @param mixed $value The value to filter the field.
     */
    function addAndCondition($field, $operator, $value);
    
    /**
     * Sets a condition for a field that will be ORed with the others.
     * 
     * @param string $field The field to condition.
     * @param string $operator The operation to use. This varies based on the table implementation.
     * @param mixed $value The value to filter the field.
     */
    function addOrCondition($field, $operator, $value);
        
    /**
     * Opens a parenthesis "(" to allow complex conditions.
     */
    function openParens();
    
    /**
     * Closes a parenthesis ")" to allow complex conditions.
     */
    function closeParens();
}
