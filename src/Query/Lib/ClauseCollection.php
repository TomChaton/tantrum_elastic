<?php

namespace tantrum_elastic\Query\Lib;

use tantrum_elastic\Lib\Element;
use tantrum_elastic\Query\Base;

abstract class ClauseCollection extends Element
{
    /**
     * Add a query to the elements array
     * @param Base $query
     */
    public function addQuery(Base $query)
    {
        return $this->addElement($query);
    }

    /**
     * @inheritdoc
     */
    protected function process()
    {
        return [$this->elements];
    }
}