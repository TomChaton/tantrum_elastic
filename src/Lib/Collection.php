<?php

namespace tantrum_elastic\Lib;

/**
 * Extends the functionality of the element object with array methods to allow filters and queries to contain
 * multiple elements
 * @package tantrum_elastic\Lib
 */
abstract class Collection extends Element implements \IteratorAggregate, \ArrayAccess, \Countable
{

    /**
     * Get an array iterator (for foreach loops etc.)
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }

    /**
     * Returns whether a value exists for the provided key
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->elements);
    }

    /**
     * Get a document fron the array
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->elements[$offset];
    }

    /**
     * Set a document in the array
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $offset = is_null($offset) ? count($this->elements) : $offset;
        $this->elements[$offset] = $value;
    }

    /**
     * Unset a document from the array
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->elements[$offset]);
    }

    /**
     * Return a count of the values
     *
     * @return int
     */
    public function count()
    {
        return count($this->elements);
    }
}
