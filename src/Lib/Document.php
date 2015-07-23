<?php

namespace tantrum_elastic\Lib;

use tantrum_elastic\Exception;

class Document extends Element
{
    /**
     * The Id of the document
     * @var mixed
     */
    protected $_id;

    /**
     * The index in which this document resides
     * @var string
     */
    protected $_index;

    /**
     * The score of this document
     * @var float
     */
    protected $_score;

    /**
     * The type of document this is
     * @var string
     */
    protected $_type;

    /**
     * The source data of the document
     */
    protected $_source = [];

    /**
     * Set the document id
     * @param mixed $id
     * @return tantrum_elastic\Lib\Document
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * Get the document Id
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set the document index
     * @param mixed $index
     * @return tantrum_elastic\Lib\Document
     */
    public function setIndex($index)
    {
        $this->_index = $index;
        return $this;
    }

    /**
     * Get the document index
     * @return mixed
     */
    public function getIndex()
    {
        return $this->_index;
    }

    /**
     * Set the document score
     * Should only be set internally by the request object
     * @param  float $score
     * @return tantrum_elastic\Lib\Document
     */
    private function setScore($score)
    {
        $this->_score = $score;
        return $this;
    }

    /**
     * Get the document score
     * @return float
     */
    public function getScore()
    {
        return $this->_score;
    }

    /**
     * Set the document type
     * @param mixed $type
     * @return tantrum_elastic\Lib\Document
     */
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    /**
     * Get the document type
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Set the document source
     * @param array $source
     * @return tantrum_elastic\Lib\Document
     */
    public function setSource(array $source)
    {
        $this->_source = $source;
        return $this;
    }

    /**
     * Set the sort values
     * @param array $sort
     * @return tantrum_elastic\Lib\Document
     */
    private function setSort(array $sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * Get the sort values 
     * @return array
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Magic function for accessing document source elements
     * @param  mixed $key
     * @return mixed
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->_source)) {
            return $this->_source[$key];
        }

        throw new Exception\InvalidArrayKey(sprintf('key "%s" des not exist in this document', $key));
    }

    /**
     * Magic function for setting document source elements
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->_source[$key] = $value;
    }

    /**
     * Hydrate the document from the provided array
     * @param  array  $arrayDocument
     * @return tantrum_elastic\Lib\Document
     */
    public function buildFromArray(array $document)
    {
        foreach ($document as $key => $value) {
            switch ($key) {
                case '_id':
                    $this->setId($value);
                    break;
                case '_index':
                    $this->setIndex($value);
                    break;
                case '_score':
                    $this->setScore($value);
                    break;
                case '_type':
                    $this->setType($value);
                    break;
                case '_source':
                    $this->setSource($value);
                    break;
                case 'sort':
                    $this->setSort($value);
                    break;
                default:
                    throw new Exception\InvalidArrayKey(sprintf('Invalid document key "%s" found', print_r($key, 1)));
            }
        }
        return $this;
    }

    public function jsonSerialize()
    {
        return $this->_source;
    }
}
