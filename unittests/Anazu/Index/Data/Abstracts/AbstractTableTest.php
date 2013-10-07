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
 * Test for AbstractTable class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Index/Data/Abstracts
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class AbstractTableTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractTable
     */
    protected $table;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var array
     */
    protected $columns;

    /**
     *
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $dataDriver;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->name = 'table_name';

        $type = $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractValueType', array('varchar', 10));

        $this->columns = array(
            $this->column = $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractColumn'
            , array('column1', $type)),
            $this->column = $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractColumn'
            , array('column2', $type)),
            $this->column = $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractColumn'
            , array('column3', $type)),
        );
        $this->dataDriver = $this->getMock('\Anazu\Index\Data\Interfaces\IDataDriver');
        $this->table = $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractTable', array(
            $this->name, $this->columns, $this->dataDriver // Constructor parameters
        ));
    }
    
    public function testGetColumns()
    {
        $this->assertEquals($this->columns, $this->table->getColumns());
    }

    public function testGetDriver()
    {
        $this->assertSame($this->dataDriver, $this->table->getDriver());
    }

    public function testGetName()
    {
        $this->assertEquals($this->name, $this->table->getName());
    }

    public function testDelete()
    {
        $condition = $this->getMock('\Anazu\Index\Data\Interfaces\ICondition');
        
        $driver = $this->getMock('\Anazu\Index\Data\Interfaces\IDataDriver');
        $this->table->setDriver($driver);
        
        $driver->expects($this->once())
                ->method('delete')
                ->with(
                        $this->equalTo($this->table), $this->equalTo($condition)
                )
                ->will($this->returnValue(1));

        $result = $this->table->delete($condition);

        $this->assertEquals(1, $result);
    }

    public function testInsert()
    {
        $row = $this->getMock('\Anazu\Index\Data\Interfaces\IRow');
        
        $driver = $this->getMock('\Anazu\Index\Data\Interfaces\IDataDriver');
        $this->table->setDriver($driver);
        
        $driver->expects($this->once())
                ->method('insert')
                ->with(
                        $this->equalTo($this->table), $this->equalTo($row)
                )
                ->will($this->returnValue(true));

        $result = $this->table->insert($row);

        $this->assertEquals(true, $result);
    }

    public function testRetrieve()
    {
        $rowCollection = $this->getMock('\Anazu\Index\Data\Interfaces\IRowColection');
        $condition = $this->getMock('\Anazu\Index\Data\Interfaces\ICondition');
        
        $driver = $this->getMock('\Anazu\Index\Data\Interfaces\IDataDriver');
        $this->table->setDriver($driver);
        
        $driver->expects($this->once())
                ->method('retrieve')
                ->with(
                        $this->equalTo($this->table), $this->equalTo($condition)
                )
                ->will($this->returnValue($rowCollection));

        $result = $this->table->retrieve($condition);

        $this->assertSame($rowCollection, $result);
    }
    
    public function testUpdate()
    {
        $row = $this->getMock('\Anazu\Index\Data\Interfaces\IRow');
        $condition = $this->getMock('\Anazu\Index\Data\Interfaces\ICondition');
        
        $driver = $this->getMock('\Anazu\Index\Data\Interfaces\IDataDriver');
        $this->table->setDriver($driver);
        
        $driver->expects($this->once())
                ->method('update')
                ->with(
                        $this->equalTo($this->table), $this->equalTo($condition), $this->equalTo($row)
                )
                ->will($this->returnValue(1));

        $result = $this->table->update($condition, $row);

        $this->assertSame(1, $result);
    }

    public function testSetDriver()
    {
        $newDriver = $this->getMock('\Anazu\Index\Data\Interfaces\IDataDriver');
        
        $this->table->setDriver($newDriver);
        
        $this->assertSame($newDriver, $this->table->getDriver());
    }

    

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructInvalidName()
    {
        $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractTable', array(
            $this->table, // <- oops!
            $this->columns, $this->dataDriver // Constructor parameters
        ));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructInvalidColumns()
    {
        $fakeColumns = array(1,2,3);
        $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractTable', array(
            $this->name, 
            $fakeColumns,  // <- oops!
            $this->dataDriver
        ));
    }

}
