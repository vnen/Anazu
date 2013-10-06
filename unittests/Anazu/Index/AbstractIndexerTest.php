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
 * Test for AbstractIndexer class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @subpackage Test
 * @category Analysis
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
class AbstractIndexerTest extends \PHPUnit_Framework_TestCase
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
        $this->indexer =  $this->getMock('Anazu\Index\AbstractIndexer', array('commit'),array($this->mockDriver));
    }

    public function testGetSetTokenizer()
    {
        $old_token = $this->indexer->getTokenizer();
        $this->assertNull($old_token);

        $tokenizer = $this->getMock('\Anazu\Analysis\Tokenizer');
        $this->indexer->setTokenizer($tokenizer);

        $new_token = $this->indexer->getTokenizer();
        $this->assertSame($tokenizer, $new_token);
    }

    public function testQueueDequeueDocument()
    {
        $document = new \Anazu\Analysis\Document(1, 'this is a test');

        $old_doc = FALSE;
        try
        {
            $this->setExpectedException('\OutOfBoundsException');
            $old_doc = $this->indexer->dequeueDocument($document->getId());
        }
        catch (Exception $ex)
        {
            
        }

        $this->assertEquals(FALSE, $old_doc);

        $this->indexer->queueDocument($document);
        $new_doc = $this->indexer->dequeueDocument($document->getId());

        $this->assertSame($document, $new_doc);
    }

    public function testDequeueDocumentWithId()
    {
        $docId = 1;
        $document = new \Anazu\Analysis\Document($docId, 'this is a test');

        $this->indexer->queueDocument($document);
        $new_doc = $this->indexer->dequeueDocument($docId);

        $this->assertSame($document, $new_doc);
    }

    public function testRemoveDocumentAndCancel()
    {
        $docId = 1;
        $document = new \Anazu\Analysis\Document($docId, 'test');

        $this->indexer->removeDocument($document);
        $returned_id = $this->indexer->cancelRemoveDocument($document);
        
        $this->assertEquals($returned_id, $docId);
    }
    
    public function testRemoveDocumentAndCancelWithId()
    {
        $docId = 50;

        $this->indexer->removeDocument($docId);
        $returned_id = $this->indexer->cancelRemoveDocument($docId);
        
        $this->assertEquals($returned_id, $docId);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDequeueInvalidId()
    {
        $this->indexer->dequeueDocument($this->indexer);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRemoveInvalidId()
    {
        $this->indexer->removeDocument($this->indexer);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testDequeueInexistentId()
    {
        $this->indexer->dequeueDocument(50);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testCancelRemoveInexistentId()
    {
        $this->indexer->cancelRemoveDocument(50);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCancelRemoveInvalidId()
    {
        $this->indexer->cancelRemoveDocument($this->indexer);
    }
}