<?php

namespace tantrum_elastic\Query\Lib;

use tantrum_elastic\Lib\Element;
use tantrum_elastic\Query\Base;

/**
 * This abstract class allows child objects the ability to contain an array of queries
 * It is not intended for use with queries directly, but rather containers within them
 * @package tantrum_elastic\Query\Lib
 */
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
