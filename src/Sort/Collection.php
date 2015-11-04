<?php

namespace tantrum_elastic\Sort;

use tantrum_elastic\Lib\Collection as LibCollection;

/**
 * This class allows base queries the ability to contain many sort options
 * @package tantrum_elastic\Sort
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.0/search-request-sort.html
 */
class Collection extends LibCollection
{
    /**
     * Add a Sort object
     *
     * @param Base $sort
     *
     * @return $this
     */
    public function addSort(Base $sort)
    {
        if($sort->hasOptions()) {
            $this->offsetSet($sort->getField(), $sort);
        } else {
            $this->addOption($sort->getField(), null);
        }
        return $this;
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function extractElements()
    {
        $elements = [];
        foreach($this->elements as $key => $element) {
            $elements[][$key] = $element;
        }

        return $elements;
    }

    /**
     * @ingeritdoc
     * @return array
     */
    public function extractOptions()
    {
       return array_keys($this->options);
    }

    /**
     * Return the object name for json
     * @return string
     */
    public function getElementName()
    {
        return 'sort';
    }
}
