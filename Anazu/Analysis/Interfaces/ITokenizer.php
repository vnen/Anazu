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
 * Description of Tokenizer
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Analysis/Interfaces
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
interface ITokenizer
{
    /**
     * Separates a text in tokens.
     * 
     * @param sting $text The text to tokenize.
     * @return \Anazu\Analysis\Interfaces\ITokenCollection A collection of tokens with respective frequencies and positions.
     */
    function tokenize($text);
}
