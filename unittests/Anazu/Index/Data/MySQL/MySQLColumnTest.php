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

namespace Anazu\Index\Data\MySQL;

/**
 * Test for MySQLCondition class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Index/Data/MySQL
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class MySQLColumnTest extends \PHPUnit_Framework_TestCase
{

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
        $this->default = 25;
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructInvalidIndexForMySQL()
    {
        new MySQLColumn(
                $this->name, $this->type, $this->default, 'not an index'// <- oops
        );
    }

    public function testConstructValidIndex()
    {
        $column = new MySQLColumn(
                $this->name, $this->type, $this->default, 'INDEX'// <- oops
        );

        $this->assertEquals('INDEX', $column->getIndex());
    }

    public function testConstructValidIndexButLowerCase()
    {
        $column = new MySQLColumn(
                $this->name, $this->type, $this->default, 'index'// <- oops
        );

        $this->assertEquals('INDEX', $column->getIndex());
    }

}
