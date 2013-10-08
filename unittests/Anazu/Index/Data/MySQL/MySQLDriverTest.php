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
 * Test for MySQLDriver class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Index/Data/MySQL
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class MySQLDriverTest extends \Anazu\Tests\DatabaseTestCase
{

    /**
     * @var MySQLDriver
     */
    protected $mysql;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->mysql = new MySQLDriver($GLOBALS['DB_SERVER'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
    }

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . '/sampledata/MySQLDriverTest.xml');
    }

    public function testGetTable()
    {
        $tableColumns = array(
            new MySQLColumn('id', new MySQLValueType('int', 10), NULL, 'PRIMARY'),
            new MySQLColumn('column1', new MySQLValueType('varchar', 15), NULL, 'INDEX'),
            new MySQLColumn('column2', new MySQLValueType('int', 11), 0),
        );

        $table = $this->mysql->getTable('testTable1');

        $this->assertEquals('testTable1', $table->getName());
        $this->assertEquals($tableColumns, $table->getColumns());
        
        $table2 = $this->mysql->getTable($table);
        
        $this->assertEquals('testTable1', $table2->getName());
        $this->assertEquals($tableColumns, $table2->getColumns());
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testGetInexistentTable()
    {
        $this->mysql->getTable('notable');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetInvalidTableAnotherObjectGiven()
    {
        $this->mysql->getTable($this->mysql); // <- oops, that's no table!
    }

    public function testCommit()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testRetrieve()
    {
        $row1 = new MySQLRow(1, array(
            'column1' => 'test1',
            'column2' => 25
        ));
        $row2 = new MySQLRow(2, array(
            'column1' => 'test2',
            'column2' => 47
        ));
        $row3 = new MySQLRow(1, array(
            'column1' => 2,
            'column2' => 3,
            'column3' => 'Test.',
        ));

        $condition1 = new MySQLCondition();
        $condition1->addAndCondition('id', '=', 1);

        $condition2 = new MySQLCondition();
        $condition2->openParens();
        $condition2->addAndCondition('column2', '=', 47);
        $condition2->closeParens();
        
        $condition3 = new MySQLCondition();
        $condition3->addAndCondition('column1', '=', 2);
        $condition3->addAndCondition('column3', 'LIKE', 'Test.');

        $gotRow1 = $this->mysql->retrieve('testTable1', $condition1);
        $gotRow2 = $this->mysql->retrieve('testTable1', $condition2);
        $gotRow3 = $this->mysql->retrieve('testTable3', $condition3);

        $this->assertInstanceOf('\Anazu\Index\Data\RowCollection', $gotRow1);
        $this->assertInstanceOf('\Anazu\Index\Data\RowCollection', $gotRow2);
        $this->assertInstanceOf('\Anazu\Index\Data\RowCollection', $gotRow3);
        $this->assertCount(1, $gotRow1);
        $this->assertCount(1, $gotRow2);
        $this->assertCount(1, $gotRow3);
        $this->assertEquals($row1, $gotRow1[0]);
        $this->assertEquals($row2, $gotRow2[0]);
        $this->assertEquals($row3, $gotRow3[0]);
    }
    
    
    
    public function testRetrieveEmptyCondition()
    {
        $row1 = new MySQLRow(1, array(
            'column1' => 'test1',
            'column2' => 25
        ));
        $row2 = new MySQLRow(2, array(
            'column1' => 'test2',
            'column2' => 47
        ));
        
        $coll = new \Anazu\Index\Data\RowCollection(array($row1, $row2));

        $condition = new MySQLCondition();

        $gotRow = $this->mysql->retrieve('testTable1', $condition);

        $this->assertInstanceOf('\Anazu\Index\Data\RowCollection', $gotRow);
        $this->assertCount(2, $gotRow);
        $this->assertEquals($coll, $gotRow);
    }
    
    /**
     * @expectedException \Exception
     */
    public function testRetrieveStrangeCondition()
    {
        $condition = new MySQLCondition();
        $condition->openParens();

        $this->mysql->retrieve('testTable1', $condition);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRetrieveInvalidTableAnotherObjectGiven()
    {
        $condition = $this->getMock('\Anazu\Index\Data\Interfaces\ICondition');
        $this->mysql->retrieve($this->mysql, $condition); // <- oops, that's no table!
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testRetrieveInexistentTable()
    {
        $conditionType = $this->mysql->getTypeForDriver('ICondition');
        $condition = new $conditionType();
        $this->mysql->retrieve(
                'oops!' // <- oops, there's no such table!
                , $condition);
    }

    public function testGetTypeForDriver()
    {
        $this->assertEquals('\Anazu\Index\Data\MySQL\MySQLCondition', $this->mysql->getTypeForDriver('ICondition'));
        $this->assertEquals('\Anazu\Index\Data\MySQL\MySQLRow', $this->mysql->getTypeForDriver('IRow'));
        $this->assertEquals('\Anazu\Index\Data\MySQL\MySQLTable', $this->mysql->getTypeForDriver('ITable'));
        $this->assertEquals('\Anazu\Index\Data\MySQL\MySQLValueType', $this->mysql->getTypeForDriver('IValueType'));
        $this->assertEquals('\Anazu\Index\Data\MySQL\MySQLColumn', $this->mysql->getTypeForDriver('IColumn'));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetTypeForDriverInvalidObjectGiven()
    {
        $this->mysql->getTypeForDriver(
                $this->mysql // <- this was supposed to be a string.
                );
    }
    
    /**
     * @expectedException \OutOfBoundsException
     */
    public function testGetTypeForDriverInexistentObjectGiven()
    {
        $this->mysql->getTypeForDriver(
                'INotInterface' // <- this interface is not an existing one.
                );
    }
    
    /**
     * @expectedException \Anazu\Index\Data\MySQL\Exceptions\BadConditionException
     */
    public function testRetrieveBadConditionBinaryOperator()
    {
        $condition = new MySQLCondition();
        $condition->addAndCondition('column1', '=', array(1,2)); // there should be only one value for '='
        
        $this->mysql->retrieve('testTable1', $condition);
    }
    
    /**
     * @expectedException \Anazu\Index\Data\MySQL\Exceptions\BadConditionException
     */
    public function testRetrieveBadConditionBinaryFunction()
    {
        $condition = new MySQLCondition();
        $condition->addAndCondition('', 'STRCMP', array(1)); // there should be 2 values for STRCMP
        
        $this->mysql->retrieve('testTable1', $condition);
    }
    
    /**
     * @expectedException \Anazu\Index\Data\MySQL\Exceptions\BadConditionException
     */
    public function testRetrieveBadConditionBetweenOperator()
    {
        $condition = new MySQLCondition();
        $condition->addAndCondition('column1', 'BETWEEN', array(1)); // there should be 2 values for BETWEEN
        
        $this->mysql->retrieve('testTable1', $condition);
    }
    
    /**
     * @expectedException \Anazu\Index\Data\MySQL\Exceptions\BadConditionException
     */
    public function testRetrieveBadConditionArrayOperator()
    {
        $condition = new MySQLCondition();
        $condition->addAndCondition('column1', 'IN', 1); // there should be an array of values for IN
        
        $this->mysql->retrieve('testTable1', $condition);
    }
    

}
