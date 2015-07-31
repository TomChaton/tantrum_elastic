<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Filter;

class Filtered extends Base
{
    /**
     * Query object;
     * @var Base
     */
    protected $query;

    /**
     * Filter object
     * @var Base;
     */
    protected $filter;

    /**
     * Create the default matchAll objects
     */
    final public function __construct()
    {
        $this->addElement('query', new MatchAll());
        $this->addElement('filter', new Filter\MatchAll());
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
        $this->addElement('query', $query);
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
        $this->addElement('filter', $filter);
        return $this;
    }

    /**
     * Return a json serializable representation of this object
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->process('filtered');
    }
}
