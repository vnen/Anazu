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

use \Anazu\Index\Data\Interfaces;

/**
 * Abstract class for a column in a table.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/Interfaces
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
abstract class AbstractColumn implements Interfaces\IColumn
{

    /**
     * The name of the column.
     * @var string The name of the column.
     */
    protected $name;

    /**
     * The type of the column.
     * @var Interfaces\IValueType The type of the column.
     */
    protected $type;

    /**
     * The default value of the column.
     * @var mixed The default value of the column.
     */
    protected $default;

    /**
     * The index type for this column.
     * @var string The index type for this column.
     */
    protected $index;

    /**
     * Gets the name of the column.
     * @return string The name.
     */
    function getName()
    {
        return $this->name;
    }

    /**
     * Gets the type information about this column.
     * @return IValueType The type.
     */
    function getType()
    {
        return $this->type;
    }

    /**
     * Gets the type of index for this column, such as "Primary" or "unique".
     * @return string The index type.
     */
    function getIndex()
    {
        return $this->index;
    }

    /**
     * Gets the default value for this column.
     * @return mixed The default value.
     */
    function getDefaultValue()
    {
        return $this->default;
    }

    /**
     * Creates a new AbstractColumn.
     * @param string $name The name of this column.
     * @param \Anazu\Index\Data\Interfaces\IValueType $type The type of this column.
     * @param mixed $default The default value for this column.
     * @param string $index The type of index for this column.
     */
    public function __construct($name, Interfaces\IValueType $type, $default = NULL, $index = NULL)
    {
        if ( !is_string($name) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be %s. %s given.'
                    , 'name', 'a string', gettype($name))
            );
        }
        if ( $index !== NULL && !is_string($index) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be %s. %s given.'
                    , 'index', 'a string', gettype($index))
            );
        }
        $this->name = $name;
        $this->type = $type;
        $this->default = $default;
        $this->index = $index;
    }

}
