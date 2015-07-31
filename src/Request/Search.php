<?php

namespace tantrum_elastic\Request;

use tantrum_elastic\Lib;
use tantrum_elastic\Query;
use tantrum_elastic\Sort;

class Search extends Base
{
    use Lib\Validate\Integers;

    public function __construct()
    {
        $this->addOption('query', new Query\Filtered());
        $this->addOption('sort', new Sort\Collection());
    }

    /**
     * Set the query object
     *
     * @param Query\Base $query
     *
     * @return  Query\Base
     */
    public function setQuery(Query\Base $query)
    {
        $this->addOption('query', $query);
        return $this;
    }

    /**
     * @param integer $from
     *
     * @return $this
     */
    public function setFrom($from)
    {
        $this->validateInteger($from, 'Value for "from" must be an integer');
        $this->validateMinimumInteger($from, 0, 'Value for "from" must be greater than or equal to 0');
        $this->addOption('from', $from);
        return $this;
    }

    /**
     * Set the size of the resultset returned
     *
     * @param integer $size
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->validateInteger($size, 'Value for "size" must be an integer');
        $this->validateMinimumInteger($size, 0, 'Value for "size" must be greater than or equal to 0');
        $this->addOption('size', $size);
        return $this;
    }

    /**
     * Set the sort collection object
     *
     * @param Sort\SortCollection $sortCollection
     *
     * @return  $this
     */
    public function setSort(Sort\Collection $sortCollection)
    {
        $this->addOption('sort', $sortCollection);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAction()
    {
        return self::ACTION_SEARCH;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return self::TYPE_SEARCH;
    }

    /**
     * @inheritdoc
     */
    public function getHTTPMethod()
    {
        return self::HTTP_METHOD_GET;
    }

    /**
     * Return an array representation of this object
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->process([]);
    }
}
