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

namespace Anazu\Analysis;

/**
 * A representation of a single document in a collection.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Analysis
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class Document implements Interfaces\IDocument
{

    /**
     * Stores the id key of this document.
     * @var string|int Stores the id key of this document.
     */
    protected $id;

    /**
     * Stores the text content of this document.
     * @var string Stores the text content of this document.
     */
    protected $text;

    /**
     * Stores the custom fields of this document.
     * @var array Stores the custom fields of this document.
     */
    protected $fields = array();

    /**
     * Returns the id of this document, so it can be located in the index.
     * 
     * @return string|int The document id.
     */
    function getId()
    {
        return $this->id;
    }

    /**
     * Returns the text content of this document.
     * 
     * @return string The text.
     */
    function getText()
    {
        return $this->text;
    }

    /**
     * Gets an specific field of this document, such as title or author.
     * 
     * @param string $name The name of the field to retrieve.
     * @return mixed The value of such field.
     */
    function getField($name)
    {
        if ( !is_string($name) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be a %s. %s given.', 'name', 'string', gettype($name))
            );
        }
        if ( !isset($this->fields[$name]) )
        {
            throw new \OutOfBoundsException(
            sprintf('The field "%" was not found in this document.', $name)
            );
        }
        return $this->fields[$name];
    }

    /**
     * Sets the value of a field.
     * 
     * @param string $name The name of the field to set.
     * @param mixed $value The value to be set to.
     * @return bool TRUE if the field was already set before, FALSE otherwise.
     */
    function setField($name, $value)
    {
        if ( !is_string($name) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be a %s. %s given.', 'name', 'string', gettype($name))
            );
        }
        $this->fields[$name] = $value;
    }

    /**
     * Creates a new document.
     * 
     * @param string|int $id The unique id of this document.
     * @param string $text The text content of this document.
     */
    public function __construct($id, $text)
    {
        if ( !is_int($id) && !is_string($id) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either a %s or a %s. %s given.', 'id', 'string', 'integer', gettype($id))
            );
        }
        if ( !is_string($text) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be a %s. %s given.', 'text', 'string', gettype($text))
            );
        }
        $this->id = $id;
        $this->text = $text;
    }

}
