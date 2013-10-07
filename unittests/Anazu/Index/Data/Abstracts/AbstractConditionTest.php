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
 * Test for AbstractCondition class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Index/Data/Abstracts
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class AbstractConditionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractCondition
     */
    protected $condition;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->condition = $this->getMockForAbstractClass('\Anazu\Index\Data\Abstracts\AbstractCondition');
    }
    
    public function testAddAndCondition()
    {
        $field = 'test';
        $op = '=';
        $value = 'something';
        $cond = array(AbstractCondition::AND_COND, $field, $op, $value);
        
        $this->condition->addAndCondition($field, $op, $value);
        
        $list = $this->condition->getConditionsList();
        
        $this->assertCount(1, $list);
        $this->assertEquals($cond, $list[0]);
    }

    public function testAddOrCondition()
    {
        $field = 'test';
        $op = '=';
        $value = 'something';
        $cond = array(AbstractCondition::OR_COND, $field, $op, $value);
        
        $this->condition->addOrCondition($field, $op, $value);
        
        $list = $this->condition->getConditionsList();
        
        $this->assertCount(1, $list);
        $this->assertEquals($cond, $list[0]);
    }

    public function testAddNotCondition()
    {
        $field = 'test';
        $op = '=';
        $value = 'something';
        $cond = array(AbstractCondition::NOT_COND, $field, $op, $value);
        
        $this->condition->addNotCondition($field, $op, $value);
        
        $list = $this->condition->getConditionsList();
        
        $this->assertCount(1, $list);
        $this->assertEquals($cond, $list[0]);
    }

    public function testOpenParens()
    {
        $cond = array(AbstractCondition::OPEN_PAREN);
        
        $this->condition->openParens();
        
        $list = $this->condition->getConditionsList();
        
        $this->assertCount(1, $list);
        $this->assertEquals($cond, $list[0]);
    }

    public function testCloseParens()
    {
        $cond = array(AbstractCondition::CLOSE_PAREN);
        
        $this->condition->closeParens();
        
        $list = $this->condition->getConditionsList();
        
        $this->assertCount(1, $list);
        $this->assertEquals($cond, $list[0]);
    }

    public function testGetConditionsList()
    {
        $field = 'test';
        $op = '=';
        $value = 'something';
        
        $cond0 = array(AbstractCondition::OPEN_PAREN);
        $cond1 = array(AbstractCondition::AND_COND, $field, $op, $value);
        $cond2 = array(AbstractCondition::OR_COND, $field, $op, $value);
        $cond3 = array(AbstractCondition::NOT_COND, $field, $op, $value);
        $cond4 = array(AbstractCondition::CLOSE_PAREN);
        
        $this->condition->openParens();
        $this->condition->addAndCondition($field, $op, $value);
        $this->condition->addOrCondition($field, $op, $value);
        $this->condition->addNotCondition($field, $op, $value);
        $this->condition->closeParens();
        
        $list = $this->condition->getConditionsList();
        
        $this->assertCount(5, $list);
        $this->assertEquals($cond0, $list[0]);
        $this->assertEquals($cond1, $list[1]);
        $this->assertEquals($cond2, $list[2]);
        $this->assertEquals($cond3, $list[3]);
        $this->assertEquals($cond4, $list[4]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddAndConditionInvalidField()
    {
        $op = '=';
        $value = 'something';
        $this->condition->addAndCondition(
                $this->condition // <- oops
                , $op, $value);
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddAndConditionInvalidOperation()
    {
        $field = 'test';
        $value = 'something';
        $this->condition->addAndCondition($field , 
                $this->condition // <- oops
                , $value);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddOrConditionInvalidField()
    {
        $op = '=';
        $value = 'something';
        $this->condition->addOrCondition(
                $this->condition // <- oops
                , $op, $value);
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddOrConditionInvalidOperation()
    {
        $field = 'test';
        $value = 'something';
        $this->condition->addOrCondition($field , 
                $this->condition // <- oops
                , $value);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddNotConditionInvalidField()
    {
        $op = '=';
        $value = 'something';
        $this->condition->addNotCondition(
                $this->condition // <- oops
                , $op, $value);
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddNotConditionInvalidOperation()
    {
        $field = 'test';
        $value = 'something';
        $this->condition->addNotCondition($field , 
                $this->condition // <- oops
                , $value);
    }
}
