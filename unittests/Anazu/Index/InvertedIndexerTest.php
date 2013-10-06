<?php

namespace Anazu\Index;

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

/**
 * Test for InvertedIndexer class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Analysis
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class InvertedIndexerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractIndexer
     */
    protected $indexer;

    /**
     *
     * @var Data\Interfaces\IDataDriver
     */
    protected $mockDriver;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->mockDriver = $this->getMock('\Anazu\Index\Data\Interfaces\IDataDriver');
        $this->indexer ;
    }

    /**
     * @todo Check and change logic.
     */
    public function testCommit()
    {
        $this->markTestIncomplete('This logic must be reviewed.');
        
        $mockDriver = $this->getMock('Anazu\Index\Data\Interfaces\IDataDriver');
        $indexer = $this->getMock('Anazu\Index\AbstractIndexer', array('commit'),array($this->mockDriver));
        
        $document1 = new \Anazu\Analysis\Document(1, 'this is a test');
        $document2 = new \Anazu\Analysis\Document(2, 'this is another test');
        $document3 = new \Anazu\Analysis\Document(4, 'this is yet another test');
        
        $indexer->queueDocument($document1);
        $indexer->queueDocument($document2);
        $indexer->queueDocument($document3);
        $indexer->removeDocument(2); // Repeating the id, I'm updating the document
        $indexer->removeDocument(3);
        
        $mockTable = $this->getMock('Anazu\Index\Data\Interfaces\ITable');
        $mockDriver->expects($this->atLeastOnce())
                ->method('getTable')
                ->will($this->returnValue($mockTable));
        $mockTable->expects($this->atLeastOnce())
                ->method('update')
                ->will($this->returnValue(1));
        $mockTable->expects($this->atLeastOnce())
                ->method('delete')
                ->will($this->returnValue(1));
        $mockTable->expects($this->atLeastOnce())
                ->method('insert')
                ->will($this->returnValue(1));
        
        $indexer->commit();
    }
}