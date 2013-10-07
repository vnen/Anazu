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
 * A column in a MySQL table.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data/MySQL
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class MySQLColumn extends Abstracts\AbstractColumn
{
    /**
     * Creates a new MySQLColumn.
     * @param string $name The name of this column.
     * @param \Anazu\Index\Data\Interfaces\IValueType $type The type of this column.
     * @param mixed $default The default value for this column.
     * @param string $index The type of index for this column.
     */
    public function __construct($name, \Anazu\Index\Data\Interfaces\IValueType $type, $default = NULL, $index = NULL)
    {
        parent::__construct($name, $type, $default, $index);
        $valid_indexes = array(
            'INDEX', 'PRIMARY', 'UNIQUE', 'FULLTEXT'
        );
        if(!is_null($index) && !in_array(strtoupper($index), $valid_indexes, true))
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be a valid %s.'
                    , 'index', 'index type')
            );
        }
        elseif(!is_null($index))
        {
            $this->index = strtoupper($index);
        }
    }
}
