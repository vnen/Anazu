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
 * Interface for an object responsible for indexing tokens.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
abstract class AbstractIndexer implements Interfaces\IIndexer
{

    /**
     * The driver for persistent storage.
     * @var IDataDriver The driver for persistent storage.
     */
    protected $dataDriver;

    /**
     * The queue of documents to be indexed.
     * @var array The queue of documents to be indexed.
     */
    protected $documentAddQueue;

    /**
     * The queue of documents to be removed from the index.
     * @var array The queue of documents to be removed from the index.
     */
    protected $documentRemoveQueue;

    /**
     * The tokenizer to use when processing the documents.
     * @var \Anazu\Analysis\Interfaces\ITokenizer The tokenizer to use when processing the documents.
     */
    protected $tokenizer = NULL;

    /**
     * Sets the tokenizer to be used in this indexer.
     * 
     * @param \Anazu\Analysis\Interfaces\ITokenizer $tokenizer The tokenizer to use.
     */
    function setTokenizer(\Anazu\Analysis\Interfaces\ITokenizer $tokenizer)
    {
        $this->tokenizer = $tokenizer;
    }

    /**
     * Gets the tokenizer being used in this indexer.
     * 
     * @return \Anazu\Analysis\Interfaces\ITokenizer The tokenizer being used.
     */
    function getTokenizer()
    {
        return $this->tokenizer;
    }

    /**
     * Adds a new document to be indexed. It'll not be actually indexed
     * before the {@link commit} method is called.
     * 
     * @param IDocument $document The document to add.
     */
    function queueDocument(IDocument $document)
    {
        $this->documentAddQueue[$document->getId()] = $document;
    }

    /**
     * Removes a document from the queue to be indexed. This won't remove
     * a document from the actual index.
     * 
     * @param IDocument|int|string $id The id of the document to dequeue or an {@link IDocument}
     *        with the same id.
     * @return IDocuemnt The dequeued document.
     * @throws \InvalidArgumentException If the id is not integer nor an IDocument.
     * @throws \OutOfBoundsException If the id is not found in the queue.
     */
    function dequeueDocument($id)
    {
        if ( !is_int($id) && !is_string($id) && !($id instanceof IDocument) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either %s, %s or %s. %s given.'
                    , 'id', 'an int', 'a string', 'an IDocument', gettype($id))
            );
        }
        if ( $id instanceof IDocument )
        {
            $id = $id->getId();
        }
        if ( !isset($this->documentAddQueue[$id]) )
        {
            throw new \OutOfBoundsException(
            sprintf('The document id "%" was not set to be indexed.', $id)
            );
        }
        $doc = $this->documentAddQueue[$id];
        unset($this->documentAddQueue[$id]);
        return $doc;
    }

    /**
     * Removes a document from the actual index. The operation won't be completed
     * before there's a call to the {@link commit} method.
     * 
     * @param IDocument|int|string $id The id of the document to dequeue or an {@link IDocument}
     *        with the same id.
     * @throws \InvalidArgumentException If the id is not a integer, not a string and not an IDocument.
     */
    function removeDocument($id)
    {
        if ( !is_int($id) && !is_string($id) && !($id instanceof IDocument) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either %s, %s or %s. %s given.'
                    , 'id', 'an int', 'a string', 'an IDocument', gettype($id))
            );
        }
        if ( $id instanceof IDocument )
        {
            $id = $id->getId();
        }
        $this->documentRemoveQueue[$id] = $id;
    }

    /**
     * Removes a document from the queue to be removed from the index.
     * 
     * @param IDocument|int|string $id The id of the document to dequeue or an {@link IDocument}
     *        with the same id.
     * @throws \InvalidArgumentException If the $id has not a valid type.
     * @throws \OutOfBoundsException If the $id was not queued to be removed.
     */
    function cancelRemoveDocument($id)
    {
        if ( !is_int($id) && !is_string($id) && !($id instanceof IDocument) )
        {
            throw new \InvalidArgumentException(
            sprintf('Argument %s must be either %s, %s or %s. %s given.'
                    , 'id', 'an int', 'a string', 'an IDocument', gettype($id))
            );
        }
        if ( $id instanceof IDocument )
        {
            $id = $id->getId();
        }
        if ( !isset($this->documentRemoveQueue[$id]) )
        {
            throw new \OutOfBoundsException(
            sprintf('The document id "%" was not set to be indexed.', $id)
            );
        }
        unset($this->documentRemoveQueue[$id]);
        return($id);
    }

    /**
     * Creates a new standard indexer.
     * @param \Anazu\Index\Data\Interfaces\IDataDriver $dataDriver
     */
    public function __construct(IDataDriver $dataDriver)
    {
        $this->dataDriver = $dataDriver;
        $this->documentAddQueue = array();
        $this->documentRemoveQueue = array();
    }

    /**
     * Commit the queued alterations to the index.
     * 
     * @return bool Whether the commit operation was succesfully completed or not.
     *
    public function commit()
    {
        
    }*/

}
