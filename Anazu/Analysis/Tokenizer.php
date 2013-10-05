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
 * A class responsible of breaking a text into tokens.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Analysis
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class Tokenizer implements Interfaces\ITokenizer
{
    protected $documentId = 0;

    /**
     * Separates a text in tokens.
     * 
     * @param string|Interfaces\IDocument $document The text or document to tokenize.
     * @return \Anazu\Analysis\Interfaces\ITokenCollection A collection of tokens with respective frequencies and positions.
     */
    public function tokenize($document)
    {
        if ( !is_string($document) && !($document instanceof Interfaces\IDocument) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either %s or %s. %s given.', 'document', 'a string', 'an IDocument', gettype($document))
            );
        }
        
        if($document instanceof Interfaces\IDocument)
        {
            $this->documentId = $document->getId();
            $document = $document->getText();
        }
        
        return new TokenCollection($this->_consolidateTokens($this->_insensitizeTokens($this->_splitTokens($document))));
    }

    /**
     * Splits the text to an array of tokens.
     * 
     * @param string $text The text to split.
     * @return array The array of tokens.
     */
    protected function _splitTokens($text)
    {
        return preg_split('/[^\pL]+/u', $text);
    }

    /**
     * Converts all tokens to lower case, so the tokenization will be case
     * insensitive. Useful to have as a separate function in case of some
     * exceptions need to be applied (such as "WHO" for World Health Organization"
     * to be treated different as "who" the pronoun).
     * 
     * @param array $tokens The splitted array of tokens.
     * @return array The insensitized tokens.
     */
    protected function _insensitizeTokens($tokens)
    {
        return array_map(function($elem)
        {
            return strtolower(iconv("utf-8", "ascii//TRANSLIT//IGNORE", $elem));
        }, $tokens);
    }

    /**
     * Consolidate tokens strings into token objects.
     * 
     * @param array $tokens The array of string tokens.
     * @return array An array of token objects.
     */
    protected function _consolidateTokens($tokens)
    {
        $result = array();
        $i = 0;
        foreach ($tokens as $token)
        {
            if ( array_key_exists($token, $result) )
            {
                // @codeCoverageIgnoreStart
                $result[$token]->addPosition($i++);
            }
            // @codeCoverageIgnoreEnd
            else
            {
                $result[$token] = new Token($token, array($i++), $this->documentId);
            }
        }
        return $result;
    }

}
