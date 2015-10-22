<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Query\Lib\Filtered\Query as QueryContainer;
use tantrum_elastic\Query\Lib\Filtered\Filter as FilterContainer;
use tantrum_elastic\Filter;

/**
 * This class is responsible for provisioning and rendering the filtered query object
 * @package tantrum_elastic\Query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-filtered-query.html
 */
class Filtered extends Base
{
    /**
     * @var Base
     */
    private $query;

    /**
     * @var Filter\Base
     */
    private $filter;

    /**
     * Set the query for this query
     *
     * @param Base $query
     *
     * @return $this
     */
    public function setQuery(Base $query)
    {
        $this->query = $query;
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
        $this->filter = $filter;
        return $this;
    }

    /**
     * Create Filter containers
     * Set them to matchAll if we have no elements
     * Or set the elements if we do
     */
    protected function preProcess()
    {
        $query = new QueryContainer();
        if(is_null($this->query)) {
            $query->setMatchAll();
        } else {
            $query->addQuery($this->query);
        }
        $this->addElement($query);

        $filter = new FilterContainer();
        if(is_null($this->filter)) {
            $filter->setMatchAll();
        } else {
            $filter->addFilter($this->filter);
        }
        $this->addElement($filter);
    }
}
