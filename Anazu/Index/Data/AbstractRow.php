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

namespace Anazu\Index\Data;

/**
 * Description of AbstractRow
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
abstract class AbstractRow implements Interfaces\IRow
{

    /**
     * Stores the identification key.
     * @var int|string Stores the identification key.
     */
    protected $id = NULL;

    /**
     * Stores the values of this row.
     * @var array Stores the values of this row.
     */
    protected $fields = array();

    /**
     * Gets the identification key of this row.
     * 
     * @return string|int The id key.
     */
    function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of a field.
     * @param string $field The name of the field to set.
     * @param mixed $value The value to be set to.
     */
    function setField($field, $value)
    {
        if ( !is_string($field) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be %s. %s given.'
                    , 'field', 'a string', gettype($field))
            );
        }
        $this->fields[$field] = $value;
    }

    /**
     * Gets the value of a field.
     * @param string $field The name of the field to get.
     * @return mixed The value of such field.
     * @throws \OutOfBoundsException
     * @throws \InvalidArgumentException
     */
    function getField($field)
    {
        if ( !is_string($field) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be %s. %s given.'
                    , 'field', 'a string', gettype($field))
            );
        }
        if ( !array_key_exists($field, $this->fields) )
        {
            throw new \OutOfBoundsException(
            sprintf('The field "%" was not found in this %s.', $field, 'row')
            );
        }
        return $this->fields[$field];
    }

    /**
     * Removes the value of a field.
     * @param string $field The name of the field to unset.
     */
    public function unsetField($field)
    {
        if ( !is_string($field) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be %s. %s given.'
                    , 'field', 'a string', gettype($field))
            );
        }
        unset($this->fields[$field]);
    }

    /**
     * Creates a new row.
     * @param int|string $id The id key for this row.
     */
    public function __construct($id, $fields = NULL)
    {
        if ( !is_int($id) && !is_string($id) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either %s or %s. %s given.'
                    , 'id', 'an int', 'a string', gettype($id))
            );
        }
        $this->id = $id;
    }
    
    /**
     * Magic function to set fields.
     * @param string $name The field to set.
     * @param mixed $value The value to set the field.
     */
    public function __set($name, $value)
    {
        $this->setField($name, $value);
    }
    
    /**
     * Magic function to get fields.
     * @param string $name The field to get.
     * @return mixed The current value of the field.
     */
    public function __get($name)
    {
        return $this->getField($name);
    }
    
    /**
     * Magic method for unsetting fields.
     * @param string $name The name of the field.
     */
    public function __unset($name)
    {
        $this->unsetField($name);
    }
    /**
     * Magic method for checking if a field exists.
     * @param string $name The field to check.
     * @return bool Whether the field exists or not.
     */
    public function __isset($name)
    {
        return array_key_exists($name, $this->fields);
    }
}
