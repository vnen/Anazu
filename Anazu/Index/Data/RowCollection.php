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
 * A simple collection of rows.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Data
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class RowCollection extends \ArrayObject implements Interfaces\IRowCollection, \IteratorAggregate
{
    /**
	 * Sets the value at the specified index to newval
	 * @link http://php.net/manual/en/arrayobject.offsetset.php
	 * @param mixed $index <p>
	 * The index being set.
	 * </p>
	 * @param mixed $newval <p>
	 * The new value for the <i>index</i>.
	 * </p>
	 * @return void
     * @throws \InvalidArgumentException If the $newval is not an {@link Interfaces\IRow}.
	 */
    public function offsetSet($index, $newval)
    {
        if ( !($newval instanceof Interfaces\IRow) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be %s. %s given.'
                    , 'newval', 'an IRow', gettype($newval))
            );
        }
        parent::offsetSet($index, $newval);
    }
}
