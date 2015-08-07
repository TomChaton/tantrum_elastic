<?php

namespace tantrum_elastic\Sort;

use tantrum_elastic\Lib\Collection as LibraryCollection;

class Collection extends LibraryCollection
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
