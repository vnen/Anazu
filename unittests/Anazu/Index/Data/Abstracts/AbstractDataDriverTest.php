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
 * Test for AbstractDataDriver class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Index/Data/Abstracts
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class AbstractDataDriverTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractDataDriver
     */
    protected $dataDriver;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->dataDriver = $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractDataDriver');
    }

    public function testCreateTable()
    {
        $table = $this->getMock('\Anazu\Index\Data\Interfaces\ITable');
        $this->dataDriver->createTable($table);

        $list = $this->dataDriver->getOperations();

        $this->assertCount(1, $list);
        $this->assertEquals(array(
            AbstractDataDriver::OP_CREATE_TABLE,
            $table
                ), $list[0]);
    }

    public function testDropTable()
    {
        $table = $this->getMock('\Anazu\Index\Data\Interfaces\ITable');
        $table->expects($this->atLeastOnce())
                ->method('getName')
                ->will($this->returnValue('table_name'));
        $this->dataDriver->dropTable($table);

        $list = $this->dataDriver->getOperations();

        $this->assertCount(1, $list);
        $this->assertEquals(array(
            AbstractDataDriver::OP_DROP_TABLE,
            'table_name'
                ), $list[0]);
    }

    public function testDropWithNameTable()
    {
        $tableName = 'table_name';
        $this->dataDriver->dropTable($tableName);

        $list = $this->dataDriver->getOperations();

        $this->assertCount(1, $list);
        $this->assertEquals(array(
            AbstractDataDriver::OP_DROP_TABLE,
            $tableName
                ), $list[0]);
    }

    public function testInsert()
    {
        $row = $this->getMock('\Anazu\Index\Data\Interfaces\IRow');
        $table = $this->getMock('\Anazu\Index\Data\Interfaces\ITable');
        $table->expects($this->atLeastOnce())
                ->method('getName')
                ->will($this->returnValue('table_name'));
        $this->dataDriver->insert($table, $row);

        $list = $this->dataDriver->getOperations();

        $this->assertCount(1, $list);
        $this->assertEquals(array(
            AbstractDataDriver::OP_INSERT,
            'table_name',
            $row
                ), $list[0]);
    }

    public function testUpdate()
    {
        $row = $this->getMock('\Anazu\Index\Data\Interfaces\IRow');
        $condition = $this->getMock('\Anazu\Index\Data\Interfaces\ICondition');
        $table = $this->getMock('\Anazu\Index\Data\Interfaces\ITable');
        $table->expects($this->atLeastOnce())
                ->method('getName')
                ->will($this->returnValue('table_name'));
        $this->dataDriver->update($table, $condition, $row);

        $list = $this->dataDriver->getOperations();

        $this->assertCount(1, $list);
        $this->assertEquals(array(
            AbstractDataDriver::OP_UPDATE,
            'table_name',
            $condition,
            $row,
                ), $list[0]);
    }

    public function testDelete()
    {
        $condition = $this->getMock('\Anazu\Index\Data\Interfaces\ICondition');
        $table = $this->getMock('\Anazu\Index\Data\Interfaces\ITable');
        $table->expects($this->atLeastOnce())
                ->method('getName')
                ->will($this->returnValue('table_name'));

        $this->dataDriver->delete($table, $condition);

        $list = $this->dataDriver->getOperations();

        $this->assertCount(1, $list);
        $this->assertEquals(array(
            AbstractDataDriver::OP_DELETE,
            'table_name',
            $condition,
                ), $list[0]);
    }
    
    public function testInsertWithTableName()
    {
        $row = $this->getMock('\Anazu\Index\Data\Interfaces\IRow');
        $table_name = 'table_name';
        $this->dataDriver->insert($table_name, $row);

        $list = $this->dataDriver->getOperations();

        $this->assertCount(1, $list);
        $this->assertEquals(array(
            AbstractDataDriver::OP_INSERT,
            $table_name,
            $row
                ), $list[0]);
    }

    public function testUpdateWithTableName()
    {
        $row = $this->getMock('\Anazu\Index\Data\Interfaces\IRow');
        $condition = $this->getMock('\Anazu\Index\Data\Interfaces\ICondition');
        $table_name = 'table_name';
        $this->dataDriver->update($table_name, $condition, $row);

        $list = $this->dataDriver->getOperations();

        $this->assertCount(1, $list);
        $this->assertEquals(array(
            AbstractDataDriver::OP_UPDATE,
            $table_name,
            $condition,
            $row,
                ), $list[0]);
    }

    public function testDeleteWithTableName()
    {
        $condition = $this->getMock('\Anazu\Index\Data\Interfaces\ICondition');
        $table_name = 'table_name';

        $this->dataDriver->delete($table_name, $condition);

        $list = $this->dataDriver->getOperations();

        $this->assertCount(1, $list);
        $this->assertEquals(array(
            AbstractDataDriver::OP_DELETE,
            $table_name,
            $condition,
                ), $list[0]);
    }

    public function testGetOperations()
    {
        $row = $this->getMock('\Anazu\Index\Data\Interfaces\IRow');
        $condition = $this->getMock('\Anazu\Index\Data\Interfaces\ICondition');
        $table = $this->getMock('\Anazu\Index\Data\Interfaces\ITable');
        $table->expects($this->atLeastOnce())
                ->method('getName')
                ->will($this->returnValue('table_name'));

        $op0 = array(AbstractDataDriver::OP_INSERT, 'table_name', $row);
        $op1 = array(AbstractDataDriver::OP_UPDATE, 'table_name', $condition, $row);
        $op2 = array(AbstractDataDriver::OP_DELETE, 'table_name', $condition);

        $this->dataDriver->insert($table, $row);
        $this->dataDriver->update($table, $condition, $row);
        $this->dataDriver->delete($table, $condition);

        $list = $this->dataDriver->getOperations();

        $this->assertCount(3, $list);
        $this->assertEquals($op0, $list[0]);
        $this->assertEquals($op1, $list[1]);
        $this->assertEquals($op2, $list[2]);
    }

    public function testRollBack()
    {
        $row = $this->getMock('\Anazu\Index\Data\Interfaces\IRow');
        $condition = $this->getMock('\Anazu\Index\Data\Interfaces\ICondition');
        $table = $this->getMock('\Anazu\Index\Data\Interfaces\ITable');
        $table->expects($this->atLeastOnce())
                ->method('getName')
                ->will($this->returnValue('table_name'));

        $this->dataDriver->insert($table, $row);
        $this->dataDriver->update($table, $condition, $row);
        $this->dataDriver->delete($table, $condition);
        
        $this->dataDriver->rollBack();
        
        $list = $this->dataDriver->getOperations();

        $this->assertEmpty($list);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDropTableInvalidName()
    {
        $this->dataDriver->dropTable($this->dataDriver); // <- oops!
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInsertInvalidTable()
    {
        $row = $this->getMock('\Anazu\Index\Data\Interfaces\IRow');
        $this->dataDriver->insert($this->dataDriver, // <- oops!
                $row
                ); 
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateInvalidTable()
    {
        $this->dataDriver->update($this->dataDriver, // <- oops!
                $this->getMock('\Anazu\Index\Data\Interfaces\ICondition'),
                $this->getMock('\Anazu\Index\Data\Interfaces\IRow')
                ); 
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDeleteInvalidTable()
    {
        $this->dataDriver->delete($this->dataDriver, // <- oops!
                $this->getMock('\Anazu\Index\Data\Interfaces\ICondition')
                ); 
    }

}
