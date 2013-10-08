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

use Anazu\Index\Data\Interfaces\ICondition;

/**
 * A condition for a search in the table. It supports multiple search conditions stacked together in only one object.
 * The functions in this interface should make difference of the order in which they are called.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/Abstracts
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
abstract class AbstractCondition implements ICondition
{

    /**
     * An OR condition.
     */
    const OR_COND = 'OR';

    /**
     * An AND condition.
     */
    const AND_COND = 'AND';

    /**
     * Opening parenthesis.
     */
    const OPEN_PAREN = '(';

    /**
     * Closing parenthesis.
     */
    const CLOSE_PAREN = ')';

    /**
     * The list of conditions.
     * @var array The list of conditions.
     */
    protected $conditions = array();

    /**
     * Sets a condition for a field that will be ANDed with the others.
     * 
     * @param string $field The field to condition.
     * @param string $operator The operation to use. This varies based on the table implementation.
     * @param mixed $value The value to filter the field.
     */
    public function addAndCondition($field, $operator, $value)
    {
        list($field, $operator) = $this->testFieldAndOperator($field, $operator);
        $this->conditions[] = array(
            self::AND_COND,
            $field,
            $operator,
            $value,
        );
    }

    /**
     * Sets a condition for a field that will be ORed with the others.
     * 
     * @param string $field The field to condition.
     * @param string $operator The operation to use. This varies based on the table implementation.
     * @param mixed $value The value to filter the field.
     */
    public function addOrCondition($field, $operator, $value)
    {
        list($field, $operator) = $this->testFieldAndOperator($field, $operator);
        $this->conditions[] = array(
            self::OR_COND,
            $field,
            $operator,
            $value,
        );
    }

    /**
     * Sumarize the test to see if the field and operator are valid.
     * @param string $field The field.
     * @param string $operator The operator.
     * @throws \InvalidArgumentException If any of it is not valid.
     */
    protected function testFieldAndOperator($field, $operator)
    {
        if ( !is_string($field) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be %s. %s given.'
                    , 'field', 'a string', gettype($field))
            );
        }
        if ( !is_string($operator) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be %s. %s given.'
                    , 'operator', 'a string', gettype($operator))
            );
        }
        return array($field, $operator);
    }

    /**
     * Opens a parenthesis "(" to allow complex conditions.
     */
    public function openParens()
    {
        $this->conditions[] = array(self::OPEN_PAREN);
    }

    /**
     * Closes a parenthesis ")" to allow complex conditions.
     */
    public function closeParens()
    {
        $this->conditions[] = array(self::CLOSE_PAREN);
    }

    /**
     * Retrieve the list of conditions.
     * @return array The list of conditions.
     */
    public function getConditionsList()
    {
        return $this->conditions;
    }

}
