<?php

namespace tantrum_elastic\Sort;

use tantrum_elastic\Lib;

class SortCollection extends Lib\Element
{
    
    /**
     * Array of Sort objects
     * @var array
     */
    private $sorts = [];

    /**
     * Add a Sort object
     * @param tantrum_elastic\Sort\Base $sort
     */
    public function addSort(Base $sort)
    {
        $this->sorts[] = $sort;
    }

    /**
     * Return the array representation of this object
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'sort' => $this->sorts,
        ];
    }
}
