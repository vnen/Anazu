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
 * An interface for single token object.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Analysis/Interfaces
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
interface IToken
{
    /**
     * Gets the token (word) stored here.
     * 
     * @return string The token.
     */
    function getToken();
    /**
     * Gets the positions of the token in the document.
     * 
     * @return array The 0-indexed positions sorted in ascending order.
     */
    function getPositions();
    /**
     * Adds a text position for this token.
     * 
     * @param int $position The position to add.
     */
    function addPosition($position);
}
