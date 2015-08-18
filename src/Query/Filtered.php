<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Filter;

class Filtered extends Base
{
    /**
     * Create the default matchAll objects
     */
    final public function __construct()
    {
        $this->addOption('query', new MatchAll());
        $this->addOption('filter', new Filter\MatchAll());
    }

    /**
     * Set the query for this query
     *
     * @param Base $query
     *
     * @return $this
     */
    public function setQuery(Base $query)
    {
        $this->addOption('query', $query);
        return $this;
    }

    /**
     * Set the filter for this query
     *
     * @param Filter\Base $filter
     *
     * @return $this
     */
    public function setFilter(Filter\Base $filter)
    {
        $this->addOption('filter', $filter);
        return $this;
    }
}
