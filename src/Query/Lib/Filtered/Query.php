<?php

namespace tantrum_elastic\Query\Lib\Filtered;

use tantrum_elastic\Query\Base;

class Query extends Container
{
    /**
     * Add a query element
     * @param Base $query
     */
    public function addQuery(Base $query)
    {
        $this->addElement($query);
    }
}