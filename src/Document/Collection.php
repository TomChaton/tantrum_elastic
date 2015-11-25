<?php

namespace tantrum_elastic\Document;

use tantrum_elastic\Lib\Collection as BaseCollection;
use tantrum_elastic\Exception;

/**
 * Container for document objects
 * @package tantrum_elastic\Lib
 */
class Collection extends BaseCollection
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
            $document = $this->make('tantrum_elastic\Document\Single');
            $document->buildFromArray($arrayDocument);
            $this->addDocument($document, $key);
        }

        return $this;
    }

    /**
     * Add a document to the collection
     *
     * @param Single $document
     * @param mixed $offset
     */
    protected function addDocument(Single $document, $offset = null)
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
