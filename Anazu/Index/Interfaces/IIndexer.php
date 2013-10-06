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

namespace Anazu\Index\Interfaces;

use Anazu\Analysis\Interfaces\IDocument;
/**
 * Interface for an object responsible for indexing tokens.
 * 
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Index/Interfaces
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
interface IIndexer
{    
    /**
     * Sets the tokenizer to be used in this indexer.
     * 
     * @param \Anazu\Analysis\Interfaces\ITokenizer $tokenizer The tokenizer to use.
     */
    function setTokenizer(\Anazu\Analysis\Interfaces\ITokenizer $tokenizer);
    
    /**
     * Gets the tokenizer being used in this indexer.
     * 
     * @return \Anazu\Analysis\Interfaces\ITokenizer The tokenizer being used.
     */
    function getTokenizer();
    
    /**
     * Adds a new document to be indexed. It should not be actually indexed
     * before the {@link commit} method is called.
     * 
     * @param IDocument $document The document to add.
     */
    function queueDocument(IDocument $document);
    
    /**
     * Removes a document from the queue to be indexed. This should not remove
     * a document from the actual index.
     * 
     * @param IDocument|int $id The id of the document to dequeue or an {@link IDocument}
     *        with the same id.
     * @return IDocuemnt The dequeued document.
     */
    function dequeueDocument($id);

    /**
     * Removes a document from the actual index. The operation should not be completed
     * before there's a call to the {@link commit} method.
     * 
     * @param IDocument|int $id The id of the document to remove or an {@link IDocument}
     *        with the same id.
     */
    function removeDocument($id);
    
    /**
     * Removes a document from the queue to be removed from the index.
     * 
     * @param IDocument|int $id The id of the document to dequeue or an {@link IDocument}
     *        with the same id.
     */
    function cancelRemoveDocument($id);
    
    /**
     * Commit the queued alterations to the index.
     * 
     * @return bool Whether the commit operation was succesfully completed or not.
     */
    function commit();    
}
