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

use Anazu\Index\Data\Abstracts;

/**
 * Condition in a MySQL database.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/MySQL
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class MySQLCondition extends Abstracts\AbstractCondition
{

    /**
     * Sumarize the test to see if the field and operator are valid.
     * @param string $field The field.
     * @param string $operator The operator.
     * @throws \InvalidArgumentException If any of it is not valid.
     */
    protected function testFieldAndOperator($field, &$operator)
    {
        parent::testFieldAndOperator($field, $operator);

        $operators = array(
            '=', '<', '>', '<=>', '<=', '>=', '!=', '<>', '>',
            'IN', 'LIKE', 'GREATEST', 'LEAST', 'IS', 'ISNULL',
            'INTERVAL', 'BETWEEN', 'STRCMP', 'COALESCE'
        );
        $operator = strtoupper($operator);
        if ( !in_array($operator, $operators, true) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be a valid %s.'
                    , 'operator', 'operator')
            );
        }
    }

}
