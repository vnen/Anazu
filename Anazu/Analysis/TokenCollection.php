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
 * A collection of tokens.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Analysis
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class TokenCollection extends \ArrayObject implements Interfaces\ITokenCollection
{

    /**
     * Stores an array of tokens for quick reference.
     * @var array Stores an array of tokens for quick reference.
     */
    protected $tokens = array();

    /**
     * Stores a map between tokens strings and keys numbers.
     * @var array Stores a map between tokens strings and keys numbers.
     */
    protected $reference = array();

    /**
     * Gets all the tokens as an array.
     * 
     * @return array The set of all tokens.
     */
    public function getTokensArray()
    {
        ksort($this->tokens);
        return $this->tokens;
    }

    /**
     * Gets all the unique tokens as an array.
     * 
     * @return array The set of all unique tokens.
     */
    public function getUniqueTokensArray()
    {
        $array = array_keys((array) $this);
        sort($array);
        return $array;
    }

    /**
     * Appends a token to the collection.
     * @param Interfaces\IToken $token The token to append.
     * @throws \InvalidArgumentException
     */
    public function offsetSet($index, $token)
    {
        if (!$token instanceof Interfaces\IToken)
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be an %s. %s given.', 'token', 'IToken', gettype($token))
            );
        }
        $this->tokens += array_combine($token->getPositions(), array_fill(0, count($token->getPositions()), $token->getToken()));
        $this->reference[$index] = $token->getToken();
        parent::offsetSet($token->getToken(), $token);
    }

    public function offsetUnset($index)
    {
        if (!isset($this->reference[$index]))
        {
            return;
        }
        $ref = $this->reference[$index];
        unset($this->reference[$index]);
        $this->tokens = array_filter($this->tokens, function($elem)use($ref)
        {
            return $elem !== $ref;
        });
        parent::offsetUnset($ref);
    }

    /**
     * Builds a new TokenCollection.
     * @param array $start An array of {@link Interfaces\IToken} objects to start the collection.
     * @throws \InvalidArgumentException
     */
    public function __construct(array $start = array())
    {
        parent::__construct(array());
        $this->tokens = array();
        $this->_buildTokens($start);
    }

    /**
     * Builds the initial token index.
     * @param array $array
     */
    protected function _buildTokens(array $array)
    {
        foreach ($array as $ref => $token)
        {
            $this->offsetSet($ref, $token);
        }
    }

}
