<?php

namespace tantrum_elastic\Lib;

use tantrum_elastic\Exception;

class DocumentCollection extends Collection
{
    /**
     * Populate from an array of documents
     *
     * @param array $documents
     *
     * @return $this
     */
    public function buildFromArray(array $documents)
    {
        foreach ($documents as $key => $arrayDocument) {
            $document = new Document();
            $document->buildFromArray($arrayDocument);
            $this->addDocument($document, $key);
        }

        return $this;
    }

    /**
     * Add a document to the collection
     *
     * @param Document $document
     * @param mixed $offset
     */
    protected function addDocument(Document $document, $offset = null)
    {
        return $this->offsetSet($offset, $document);
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        return $this->elements;
    }
}
