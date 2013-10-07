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
 * Test for AbstractColumn class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Index/Data/Abstracts
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class AbstractColumnTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractColumn
     */
    protected $column;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var \Anazu\Index\Data\Interfaces\IValueType
     */
    protected $type;

    /**
     *
     * @var string
     */
    protected $index;

    /**
     *
     * @var int
     */
    protected $default;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->name = 'column';
        $this->type = $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractValueType', array('varchar', 10));
        $this->index = 'index';
        $this->default = 25;
        $this->column = $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractColumn'
                , array($this->name, $this->type, $this->default, $this->index));
    }

    public function testGetName()
    {
        $this->assertEquals($this->name, $this->column->getName());
    }

    public function testGetType()
    {
        $this->assertSame($this->type, $this->column->getType());
    }

    public function testGetIndex()
    {
        $this->assertEquals($this->index, $this->column->getIndex());
    }

    public function testGetDefaultValue()
    {
        $this->assertEquals($this->default, $this->column->getDefaultValue());
    }
    
    public function testGetNullIndex()
    {
        $column = $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractColumn'
                , array($this->name, $this->type));
        $this->assertNull($column->getIndex());
    }

    public function testGetNullDefaultValue()
    {
        $column = $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractColumn'
                , array($this->name, $this->type));
        $this->assertNull($column->getDefaultValue());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructInvalidNameObjectGiven()
    {
        $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractColumn'
                , array($this->column, // <- oops
                    $this->type, $this->default, $this->index));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructInvalidNameIntGiven()
    {
        $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractColumn'
                , array(60, // <- oops
                    $this->type, $this->default, $this->index));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructInvalidIndexObjectGiven()
    {
        $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractColumn'
                , array($this->name, $this->type, $this->default, 
                    $this->column // <- oops
                    ));
    }
}
