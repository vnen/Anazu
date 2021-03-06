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
 * Represents a single token in a document.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Analysis
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class Token implements Interfaces\IToken
{

    /**
     * The stored token.
     * @var string The stored token.
     */
    protected $token = NULL;

    /**
     * The stored positions.
     * @var array The stored positions.
     */
    protected $positions = NULL;
    
    /**
     * The id of the document associated with this token.
     * @var string|int The id of the document associated with this token.
     */
    protected $documentId = NULL;

    /**
     * Gets the positions of the token in the document.
     * 
     * @return array The 0-indexed positions sorted in ascending order.
     */
    public function getPositions()
    {
        ksort($this->positions);
        return array_keys($this->positions);
    }

    /**
     * Gets the token (word) stored here.
     * 
     * @return string The token.
     */
    public function getToken()
    {
        return $this->token;
    }
    
    public function getDocumentId()
    {
        return $this->documentId;
    }

    /**
     * Constructs a new token.
     * 
     * @param string $token The token itself.
     * @param array $positions The positions where the token appear in the document.
     * @param int|string|Interfaces\IDocument The document associated with this token or only its id key.
     * @throws \InvalidArgumentException
     */
    public function __construct($token, array $positions, $id)
    {
        if (!is_string($token))
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be a %s. %s given.', 'token', 'string', gettype($token))
            );
        }
        if (!is_string($id) && !is_int($id) && !($id instanceof Interfaces\IDocument))
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either %s, %s or %s. %s given.'
                    , 'id', 'an int', 'a string', 'an IDocument', gettype($id))
            );
        }
        array_walk($positions, function($elem)
        {
            if (!is_int($elem))
            {
                throw new \InvalidArgumentException(sprintf(
                        'Argument %s must contain only %s. %s found.', 'position', 'integers', gettype($elem)
                ));
            }
        });
        
        if($id instanceof Interfaces\IDocument)
        {
            $id = $id->getId();
        }
        $this->documentId = $id;
        $this->token = $token;
        $this->positions = array_combine($positions, $positions);
    }

    /**
     * Adds a text position for this token.
     * 
     * @param int $position The position to add.
     * @throws \InvalidArgumentException
     */
    public function addPosition($position)
    {
        if (!is_int($position))
        {
            throw new \InvalidArgumentException(sprintf(
                    'Argument %s must be an integer. %s given.', 'position', gettype($position)
            ));
        }
        $this->positions[$position] = $position;
    }

    public function __toString()
    {
        return $this->getToken();
    }

}
