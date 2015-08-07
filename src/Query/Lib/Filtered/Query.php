<?php

namespace tantrum_elastic\Query\Lib\Filtered;

use tantrum_elastic\Query\Base;

/**
 * This class allows the filtered query object to contain multiple sub-queries
 * @package tantrum_elastic\Query\Lib\Filtered
 */
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
