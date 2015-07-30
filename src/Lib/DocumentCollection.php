<?php

namespace tantrum_elastic\Lib;

class DocumentCollection extends Element implements \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * Array of Documents
     *
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

    /**
     * Add a document to the collection
     *
     * @param Document $document
     * @param mixed $offset
     */
    protected function addDocument(Document $document, $offset)
    {
        $this->documents[$offset] = $document;
    }

    /**
     * Get an array iterator (for foreach loops etc.)
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->documents);
    }

    /**
     * Returns whether a value exists for the provided key
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->documents);
    }

    /**
     * Get a document fron the array
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->documents[$offset];
    }

    /**
     * Set a document in the array
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->addDocument($value, $offset);
    }

    /**
     * Unset a document from the array
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->documents[$offset]);
    }

    /**
     * Return a count of the documents
     *
     * @return int
     */
    public function count()
    {
        return count($this->documents);
    }

    /**
     * Return the document array
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->documents;
    }
}
