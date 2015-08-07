<?php

namespace tantrum_elastic\Query\Lib\Filtered;

use tantrum_elastic\Filter\Base;

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