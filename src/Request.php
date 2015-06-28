<?php

namespace tantrum_elastic;

use tantrum_elastic\Lib;

class Request extends Lib\Element
{
    use Lib\Validate\Integers;

    /**
     * Query object
     * @var tantrum_elastic\Query\Base
     */
    private $query;

    /**
     * Resultset offset
     * @var integer
     */
    private $from = 0;

    /**
     * Resultset size
     * @var integer
     */
    private $size = 0;

    /**
     * Sort by
     * @var tantrum_elastic\Lib\Sort
     */
    private $sort;

    /**
     * Set the query object
     * @param tantrum_elastic\Query\Base $query
     * @return  tantrum_elastic\Query\Base
     */
    public function setQuery(Query\Base $query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @param integer $from
     * @return tantrum_elastic\Request
     */
    public function setFrom($from)
    {
        $this->validateMinimumInteger($size, 0);
        $this->from = $from;
        return $this;
    }

    /**
     * Set the size of the resultset returned
     * @param integer $size
     * @return tantrum_elastic\Request
     */
    public function setSize($size)
    {
        $this->validateMinimumInteger($size, 0);
        $this->size = $size;
        return $this;
    }

    /**
     * Set the sort field
     * @param tantrum_elastic\Lib\Sort $sort
     * @return  tantrum_elastic\Request
     */
    public function setSort(Lib\Sort $sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * Return an array representation of this object
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'query' => $this->query,
            'from'  => $this->from,
            'size'  => $this->size,
            'sort'  => $this->sort,
        ];
    }
}