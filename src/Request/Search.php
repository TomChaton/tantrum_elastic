<?php

namespace tantrum_elastic\Request;

use tantrum_elastic\Lib;
use tantrum_elastic\Query;
use tantrum_elastic\Sort;

/**
 * This class is responsible for provisioning and rendering the top level query element in an elasticsearch request
 * @package tantrum_elastic\Request
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.0/search.html
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.0/search-request-body.html
 */
class Search extends Base
{
    use Lib\Validate\Integers;

    /**
     * Set defaults
     */
    public function __construct()
    {
        $this->addElement(new Query\MatchAll());
        $this->addElement(new Sort\Collection(), false);
    }

    /**
     * Set the query object
     *
     * @param Query\Base $query
     *
     * @return  Base
     */
    public function setQuery(Query\Base $query)
    {
        $this->addElement( $query);
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
        $this->addOption('from', $from, false);
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
        $this->addOption('size', $size, false);
        return $this;
    }

    /**
     * Set the sort collection object
     *
     * @param Sort\Collection $sortCollection
     *
     * @return  $this
     */
    public function setSort(Sort\Collection $sortCollection)
    {
        $this->addElement($sortCollection, false);
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
     * @inheritdoc
     * @return string
     */
    public function getElementName()
    {
        return 'query';
    }
}
