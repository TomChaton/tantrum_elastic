<?php

namespace tantrum_elastic\Lib;

use tantrum_elastic\Exception;

/**
 * This class is responsible for provisioning and rendering documents as they are returned from elasticsearch
 * @package tantrum_elastic\Lib
 */
class Document extends Element
{
    /**
     * The Id of the document
     *
     * @var mixed
     */
    protected $id;

    /**
     * The index in which this document resides
     *
     * @var string
     */
    protected $index;

    /**
     * The score of this document
     *
     * @var float
     */
    protected $score;

    /**
     * The type of document this is
     *
     * @var string
     */
    protected $type;

    /**
     * The source data of the document
     */
    protected $source = [];

    /**
     * The fields that were used for sorting this document
     */
    protected $sort = [];

    /**
     * Set the document id
     *
     * @param mixed $id
     *
     * @return Document
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the document Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the document index
     *
     * @param mixed $index
     *
     * @return Document
     */
    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }

    /**
     * Get the document index
     *
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Set the document score
     * Should only be set internally by the request object
     *
     * @param  float $score
     *
     * @return Document
     */
    private function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    /**
     * Get the document score
     *
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set the document type
     *
     * @param mixed $type
     *
     * @return Document
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get the document type
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the document source
     *
     * @param array $source
     *
     * @return Document
     */
    public function setSource(array $source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Set the sort values
     *
     * @param array $sort
     *
     * @return Document
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
     *
     * @param  mixed $key
     *
     * @throws Exception\InvalidArrayKey
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->source)) {
            return $this->source[$key];
        }

        throw new Exception\InvalidArrayKey(sprintf('key "%s" des not exist in this document', $key));
    }

    /**
     * Magic function for setting document source elements
     *
     * @param  mixed $key
     * @param  mixed $value
     *
     * @return void
     */
    public function __set($key, $value)
    {
        $this->source[$key] = $value;
    }

    /**
     * Hydrate the document from the provided array
     *
     * @param  array  $document
     *
     * @return Document
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

    /**
     * @inheritdoc
     */
    public function process()
    {
        return $this->source;
    }
}
