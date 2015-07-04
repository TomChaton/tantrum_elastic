<?php

namespace tantrum_elastic\Lib;

class Document
{
    const KEY_ID    = '_id';
    const KEY_INDEX = '_index';
    const KEY_SCORE = '_score';
    const KEY_TYPE  = '_type';

    /**
     * The source of the document
     * @var array
     */
    protected $document = [];

    /**
     * Keys required for indexing
     * @var array
     */
    private $requiredKeys = [
        self::KEY_ID,
        self::KEY_INDEX,
        self::KEY_TYPE,
    ];

    /**
     * Keymap for the magic __get method
     * @var array
     */
    private $keyMap = [
        'id'    => self::KEY_ID,
        'index' => self::KEY_INDEX,
        'score' => self::KEY_SCORE,
        'type'  => self::KEY_TYPE,
    ];

    /**
     * Set the document id
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set the document type
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Set the document index
     * @param mixed $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * Set the document score
     * Should only be set internally by the request object
     * @param float $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * Set the source of a document
     * @param array $source 
     */
    public function setDocument(array $document)
    {
        // @todo: Validate document keys
        $this->document = $document;
    }

    /**
     * Magic function for accessing document elements
     * @param  mixed $key
     * @return mixed
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->keyMap)) {
            return $this->document[$this->keymap[$key]];
        } elseif (array_key_exists($key, $this->document['_source'])) {
            return $this->document['_source'][$key];
        }

        throw new Exception\InvalidArrayKey(sprintf('key "%s" des not exist in this document', $key));
    }

    public function buildFromArray($arrayDocument, $indexing = false)
    {
        $this->document = $arrayDocument;
    }
}
