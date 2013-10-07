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
 * Test for RowCollection class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Index/Data/Abstracts
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class RowCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var RowCollection
     */
    protected $rowCollection;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->rowCollection = new RowCollection;
    }
    
    public function testSetAndGet()
    {
        $row = $this->getMock('Anazu\Index\Data\Interfaces\IRow');
        
        $key = 5;
        
        $this->rowCollection[$key] = $row;
        
        $this->assertSame($row, $this->rowCollection[$key]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetInvalidValue()
    {
        $this->rowCollection[] = $this->rowCollection; // Invalid type, should be an IRow
    }
}
