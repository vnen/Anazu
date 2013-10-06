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

use InvalidArgumentException;
use OutOfBoundsException;

/**
 * Test for Document class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Analysis
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class DocumentTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Document
     */
    protected $document;

    /**
     *
     * @var string
     */
    protected $text;

    /**
     *
     * @var int
     */
    protected $id;

    protected function setUp()
    {
        parent::setUp();

        $this->text = 'This is a document text example just for testing.';
        $this->id = 20;
        $this->document = new Document($this->id, $this->text);
    }

    public function testGetText()
    {
        $text = $this->document->getText();
        
        $this->assertEquals($this->text, $text);
    }
    
    public function testGetId()
    {
        $id = $this->document->getId();
        
        $this->assertEquals($this->id, $id);
    }
    
    public function testSetAndGetField()
    {
        $title = 'This is title';
        $this->document->setField('title', $title);
        
        $got_title = $this->document->getField('title');
        
        $this->assertEquals($title, $got_title);
    }

    /**
     * @expectedException OutOfBoundsException
     */
    public function testGetUndefinedFieldError()
    {
        $this->document->getField('ooops');
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetInvalidFieldName()
    {
        $this->document->getField($this->document);
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetInvalidFieldName()
    {
        $this->document->setField($this->document, 'a');
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructInvalidId()
    {
        new Document($this->document, 'text');
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructInvalidText()
    {
        new Document(2, array(1,2,4));
    }
}
