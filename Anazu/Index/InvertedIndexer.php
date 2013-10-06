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

namespace Anazu\Index;

use Anazu\Analysis\Interfaces\IDocument;
use Anazu\Index\Data\Interfaces\IDataDriver;

/**
 * Description of InvertedIndexer
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class InvertedIndexer extends AbstractIndexer
{
    /**
     * Commit the queued alterations to the index.
     * 
     * @return bool Whether the commit operation was succesfully completed or not.
     */
    public function commit()
    {
        
    }

}
