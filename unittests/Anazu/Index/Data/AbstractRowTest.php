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

namespace Anazu\Index\Data;

/**
 * Test for InvertedIndexer class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Index/Data
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class AbstractRowTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractRow
     */
    protected $row;

    /**
     *
     * @var int
     */
    protected $rowId;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->rowId = 20;
        $this->row = $this->getMockForAbstractClass('\Anazu\Index\Data\AbstractRow', array($this->rowId));
    }

    public function testGetId()
    {
        $id = $this->row->getId();

        $this->assertEquals($this->rowId, $id);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructInvalidId()
    {
        $this->row = $this->getMockForAbstractClass('\Anazu\Index\Data\AbstractRow', array($this->row));
    }

    public function testSetAndGetField()
    {
        $fieldName = 'field';
        $fieldValue = 'value';

        $this->row->setField($fieldName, $fieldValue);

        $returnedValue = $this->row->getField($fieldName);

        $this->assertEquals($fieldValue, $returnedValue);
    }
    
    public function testUnsetField()
    {
        $fieldName = 'field';
        $fieldValue = 'value';

        $this->row->setField($fieldName, $fieldValue);
        
        $this->row->unsetField($fieldName);
        
        $this->setExpectedException('\OutOfBoundsException');
        $this->row->getField($fieldName);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUnsetFieldInvalidValue()
    {
        $this->row->unsetField($this->row);
    }
    
    public function testUnsetFieldInexistentValue()
    {
        $this->row->unsetField('oops!');
        // As long as there's no error, that's ok
        // as it's similar to the "unset" PHP construct.
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetFieldInvalidName()
    {
        $this->row->setField($this->row, 'whatever');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetFieldInvalidName()
    {
        $this->row->getField($this->row);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testGetFieldInexistentName()
    {
        $this->row->getField('oops!');
    }

    public function testMagicSetAndGet()
    {
        $fieldValue = 'value';
        
        $this->row->field = $fieldValue;
        
        $this->assertEquals($fieldValue, $this->row->field);
    }
    
    public function testMagicUnset()
    {
        $fieldValue = 'value';
        
        $this->row->field = $fieldValue;
        
        unset($this->row->field);
        
        $this->setExpectedException('\OutOfBoundsException');
        $this->row->field;
    }
    
    public function testMagicIsset()
    {
        $fieldValue = 'value';
        
        $this->row->field = $fieldValue;
        
        $this->assertTrue(isset($this->row->field));
    }
}
