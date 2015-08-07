<?php

namespace tantrum_elastic\Query\Lib\Filtered;

use tantrum_elastic\Filter\Base;

/**
 * This class allows the filtered query object to contain multiple sub-filters
 * @package tantrum_elastic\Query\Lib\Filtered
 */
class Filter extends Container
{
    /**
     * Add a filter element
     * @param Base $filter
     */
    public function addFilter(Base $filter)
    {
        $this->addElement($filter);
    }
}
