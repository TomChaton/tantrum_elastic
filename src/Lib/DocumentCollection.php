<?php

namespace tantrum_elastic\Lib;

class DocumentCollection implements \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * Array of Documents
     * @type array
     */
    protected $documents = [];

    public function buildFromArray(array $arrayDocuments)
    {
        $arrayDocuments = $this->validateArrayDocuments($arrayDocuments);
        foreach ($arrayDocuments as $key => $arrayDocument) {
            $document = new Document();
            $document->buildFromArray($arrayDocument);
            $this->documents[] = $document;
        }

        return $this;
    }

    protected function validateArrayDocuments($arrayDocuments)
    {
        // @todo: actually validate this!
        return $arrayDocuments['hits'];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->documents);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($documents[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->documents[$offset];
    }

    protected function addDocument(Document $document, $offset)
    {
        $this->documents[$offset] = $document;
    }

    public function offsetSet($offset, $value)
    {
        $this->addDocument($value, $offset);
    }

    public function offsetUnset($offset)
    {
        unset($this->documents[$offset]);
    }

    public function count()
    {
        return count($thid->documents);
    }
}
