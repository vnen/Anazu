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

/**
 * Abstract class base for a type of data in a column.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/Abstracts
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
abstract class AbstractValueType implements \Anazu\Index\Data\Interfaces\IValueType
{

    /**
     * The name of this type.
     * @var string The name of this type.
     */
    protected $name;
    /**
     * The size or set for this type.
     * @var mixed The size or set for this type.
     */
    protected $size;
    /**
     * Gets the name of the type.
     * @return string The name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the size of this type to be stored.
     * @return mixed The size to be stored or extra info, as in set, or enum types.
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Creates a new AbstractValueType.
     * @param string $name The name of this type.
     * @param mixed $size The size or set for this type.
     * @throws \InvalidArgumentException If the name is not a string.
     */
    public function __construct($name, $size = NULL)
    {
        if ( !is_string($name) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be %s. %s given.'
                    , 'name', 'a string', gettype($name))
            );
        }
        $this->name = $name;
        $this->size = $size;
    }

}
