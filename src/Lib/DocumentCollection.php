<?php

namespace tantrum_elastic\Lib;

class DocumentCollection extends Element implements \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * Array of Documents
     * @type array
     */
    protected $documents = [];

    public function buildFromArray(array $documents)
    {
        foreach ($documents as $key => $arrayDocument) {
            $document = new Document();
            $document->buildFromArray($arrayDocument);
            $this->documents[$key] = $document;
        }

        return $this;
    }

    protected function addDocument(Document $document, $offset)
    {
        $this->documents[$offset] = $document;
    }


    public function getIterator()
    {
        return new \ArrayIterator($this->documents);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->documents);
    }

    public function offsetGet($offset)
    {
        return $this->documents[$offset];
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
        return count($this->documents);
    }

    public function jsonSerialize()
    {
        return $this->documents;
    }
}
