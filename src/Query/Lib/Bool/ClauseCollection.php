<?php

namespace tantrum_elastic\Query\Lib\Bool;

use tantrum_elastic\Lib\Collection;
use tantrum_elastic\Query\Base;

class ClauseCollection extends Collection
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