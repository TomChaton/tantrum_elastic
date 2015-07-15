<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Filter;

class Filtered extends Base
{
    /**
     * Query object;
     * @var tantrum_elastic\Query\Base
     */
    protected $query;

    /**
     * Filter object
     * @var tantrum_elastic\Filter\Base;
     */
    protected $filter;

    /**
     * Create the default matchAll objects
     */
    public function __construct()
    {
        $this->addElement('query', new MatchAll());
        $this->addElement('filter', new Filter\MatchAll());
    }
    
    /**
     * Set the query for this query
     * @param tantrum_elastic\Query\Base $query
     */
    public function setQuery(Base $query)
    {
        $this->addElement('query', $query);
        return $this;
    }

    /**
     * Set the filter for this query
     * @param tantrum_elastic\Filter\Filter $filter
     */
    public function setFilter(Filter\Base $filter)
    {
        $this->addElement('filter', $filter);
        return $this;
    }

    /**
     * Return a json serializable representation of this object
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->process('filtered');
    }
}
