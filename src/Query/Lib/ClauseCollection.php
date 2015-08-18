<?php

namespace tantrum_elastic\Query\Lib;

use tantrum_elastic\Lib\Collection;
use tantrum_elastic\Query\Base;

abstract class ClauseCollection extends Collection
{
    /**
     * Add a query to the elements array
     * @param Base $query
     */
    public function addQuery(Base $query)
    {
        return $this->offsetSet(null, $query);
    }
}