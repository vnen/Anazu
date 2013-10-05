<?php

use \PHPUnit_Framework_TestCase;
use Anazu\Analysis\Token;
use Anazu\Analysis\Interfaces\IDocument;

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
 * Test for Token class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Analysis
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class TokenTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Anazu\Analysis\Interfaces\IToken
     */
    protected $token;

    /**
     *
     * @var string
     */
    protected $tokenString;

    /**
     *
     * @var array
     */
    protected $positions;
    /**
     *
     * @var IDocument
     */
    protected $document;
    
    /**
     *
     * @var int
     */
    protected $documentId;

    protected function setUp()
    {
        parent::setUp();

        $this->tokenString = 'test';
        $this->positions = array(0, 20, 45);
        $this->documentId = 1;
        $this->document = new Anazu\Analysis\Document($this->documentId, 'this is a test text');

        $this->token = new Token($this->tokenString, $this->positions, $this->document);
    }

    public function testGetToken()
    {
        $token = $this->token->getToken();

        $this->assertEquals($this->tokenString, $token);
    }

    public function testGetPositions()
    {
        $positions = $this->token->getPositions();

        $this->assertEquals($this->positions, $positions);
    }
    
    public function testGetDocumentId()
    {
        $retrieved_id = $this->token->getDocumentId();
        
        $this->assertEquals($this->documentId, $retrieved_id);
    }
    
    public function testGetDocumentIdFromDirectlyAssignedId()
    {
        $assigned_id = 5;
        $token = new Token($this->tokenString, $this->positions, $assigned_id);
        $retrieved_id = $token->getDocumentId();
        
        $this->assertEquals($assigned_id, $retrieved_id);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructInvalidTokenArrayGiven()
    {
        $this->setExpectedException('InvalidArgumentException');
        new Token(array(2, 4), $this->positions, $this->documentId);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructInvalidTokenObjectGiven()
    {
        $this->setExpectedException('InvalidArgumentException');
        new Token($this->token, $this->positions, $this->documentId);
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructInvalidDocumentIdGiven()
    {
        new Token($this->tokenString, $this->positions, $this->positions);
    }
    
    public function testAddPosition()
    {
        $old_positions = $this->token->getPositions();
        $pos = 5;
        
        $this->token->addPosition($pos);
        
        $new_positions = $this->token->getPositions();
        
        $this->assertNotEquals($new_positions, $old_positions);
        $this->assertNotContains($pos, $old_positions);
        $this->assertContains($pos, $new_positions);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddInvalidObjectAsPosition()
    {
        $this->token->addPosition($this->token);
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddInvalidArrayAsPosition()
    {
        $this->token->addPosition($this->positions);
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateInvalidPositions()
    {
        new Token($this->tokenString, array($this->token), $this->documentId);
    }
    
    public function testToStringConvertion()
    {
        $string = (string)$this->token;
        
        $this->assertEquals($this->tokenString, $string);
    }
}
