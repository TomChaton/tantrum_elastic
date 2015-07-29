<?php

namespace tantrum_elastic\Request;

use tantrum_elastic\Lib;
use tantrum_elastic\Query;
use tantrum_elastic\Sort;

class Search extends Base
{
    use Lib\Validate\Integers;

    /**
     * Sort by
     * @var tantrum_elastic\Sort\SortCollection
     */
    private $sort;

    public function __construct()
    {
        $this->addOption('query', new Query\Filtered());
        $this->addOption('sort', new Sort\Collection());
    }

    /**
     * Set the query object
     * @param tantrum_elastic\Query\Base $query
     * @return  tantrum_elastic\Query\Base
     */
    public function setQuery(Query\Base $query)
    {
        $this->addOption('query', $query);
        return $this;
    }

    /**
     * @param integer $from
     * @return tantrum_elastic\Request
     */
    public function setFrom($from)
    {
        $this->validateInteger($size);
        $this->validateMinimumInteger($size, 0);
        $this->addOption('from', $from);
        return $this;
    }

    /**
     * Set the size of the resultset returned
     * @param integer $size
     * @return tantrum_elastic\Request
     */
    public function setSize($size)
    {
        $this->validateInteger($size);
        $this->validateMinimumInteger($size, 0);
        $this->addOption('size', $size);
        return $this;
    }

    /**
     * Set the sort collection object
     * @param tantrum_elastic\Sort\SortCollection $sortColleaction
     * @return  tantrum_elastic\Request
     */
    public function setSort(Sort\Collection $sortCollection)
    {
        $this->addOption('sort', $sortCollection);
        return $this;
    }

    public function getAction()
    {
        return self::ACTION_SEARCH;
    }

    public function getType()
    {
        return self::TYPE_SEARCH;
    }

    public function getHTTPMethod()
    {
        return self::HTTP_METHOD_GET;
    }

    /**
     * Return an array representation of this object
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->process([]);
    }
}
