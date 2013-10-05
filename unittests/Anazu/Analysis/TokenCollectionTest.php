<?php

use \PHPUnit_Framework_TestCase;
use \Anazu\Analysis\TokenCollection;
use \Anazu\Analysis\Token;

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

/**
 * Test for TokenCollection class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Analysis
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class TokenCollectionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Anazu\Analysis\Interfaces\ITokenCollection
     */
    protected $tokenCollection;
    /**
     *
     * @var int
     */
    protected $documentId;

    protected function setUp()
    {
        parent::setUp();

        $this->tokenCollection = new TokenCollection();
        $this->documentId = 1;
    }

    public function testGetArray()
    {
        list(, $expected) = $this->fillCollection();

        $array = $this->tokenCollection->getTokensArray();

        $this->assertEquals($expected, $array);
    }

    public function testGetUniqueArray()
    {
        list($expected) = $this->fillCollection();

        $array = $this->tokenCollection->getUniqueTokensArray();

        $this->assertEquals($expected, $array);
    }

    /**
     * This just fill the collection in the class with test data.
     */
    protected function fillCollection()
    {
        $this->tokenCollection[] = new Token('this', array(0, 25, 35), $this->documentId);
        $this->tokenCollection[] = new Token('is', array(1, 26, 80, 43), $this->documentId);
        $this->tokenCollection[] = new Token('a', array(4, 8, 15, 16, 23, 42), $this->documentId);
        $this->tokenCollection[] = new Token('test', array(3), $this->documentId);
        return array(
            array('a', 'is', 'test', 'this'), // uniques
            array(// whole
                0  => 'this',
                1  => 'is',
                3  => 'test',
                4  => 'a',
                8  => 'a',
                15 => 'a',
                16 => 'a',
                23 => 'a',
                25 => 'this',
                26 => 'is',
                35 => 'this',
                42 => 'a',
                43 => 'is',
                80 => 'is',
        ));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddInvalidStringAsToken()
    {
        $this->tokenCollection[] = 'oops, this is not an object!';
    }

    public function testUnsetToken()
    {
        $this->tokenCollection[3] = new Token('a', array(0), $this->documentId);
        $filled_array = $this->tokenCollection->getTokensArray();

        $this->assertNotEmpty($filled_array);

        unset($this->tokenCollection[3]);
        $empty_array = $this->tokenCollection->getTokensArray();

        $this->assertEmpty($empty_array);
    }
    
    public function testUnsetUndefinedToken()
    {
        unset($this->tokenCollection[3]);
        // as long as there's no error, no problem.
    }

}
