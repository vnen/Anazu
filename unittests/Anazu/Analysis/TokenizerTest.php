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

use Anazu\Analysis\Interfaces\ITokenizer;
use InvalidArgumentException;

/**
 * Test for Tokeninzer class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Analysis
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class TokenizerTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var ITokenizer
     */
    protected $tokenizer;

    protected function setUp()
    {
        parent::setUp();

        $this->tokenizer = new Tokenizer();
    }

    public function testTokenizerReturnRightClass()
    {
        $tokens = $this->tokenizer->tokenize('this is a test');

        $this->assertInstanceOf('\Anazu\Analysis\Interfaces\ITokenCollection', $tokens);
    }

    public function testTokenizerReturnRightTokens()
    {
        $tokens = $this->tokenizer->tokenize('this is a text');

        $all_tokens = $tokens->getTokensArray();

        $this->assertContains('this', $all_tokens);
        $this->assertContains('is', $all_tokens);
        $this->assertContains('a', $all_tokens);
        $this->assertContains('text', $all_tokens);
    }
    
    public function testTokenizingWithDocumentGiven()
    {
        $document = new Document(1, 'this is a text');
        
        $tokens = $this->tokenizer->tokenize($document);

        $all_tokens = $tokens->getTokensArray();

        $this->assertContains('this', $all_tokens);
        $this->assertContains('is', $all_tokens);
        $this->assertContains('a', $all_tokens);
        $this->assertContains('text', $all_tokens);
    }


    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidDocumentGiven()
    {
        $this->tokenizer->tokenize($this->tokenizer);
    }
}
