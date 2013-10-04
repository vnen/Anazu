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

namespace Anazu\Analysis\Interfaces;

/**
 * A collection of token objects.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Analysis/Interfaces
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
interface ITokenCollection extends \Traversable
{
    /**
     * Gets all the tokens as an array, with positions as keys and tokens as values.
     * 
     * @return array The set of all tokens.
     */
    function getTokensArray();
    /**
     * Gets all the unique tokens as an array.
     * 
     * @return array The set of all unique tokens.
     */
    function getUniqueTokensArray();
}
