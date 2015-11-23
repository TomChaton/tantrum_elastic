<?php
/**
 * This file is part of tantrum_elastic.
 *
 *  tantrum_elastic is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  tantrum_elastic is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with tatrum_elastic.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace tantrum_elastic\Factory\Search;

use Pimple\Container;
use tantrum_elastic\Exception\InvalidArgument;
use tantrum_elastic\Payload\Search;
use tantrum_elastic\Sort;
use tantrum_elastic\Query;
use tantrum_elastic\Transport\Http;

/**
 * Base class for all search factory classes
 * @package tantrum_elastic\Factory\Search
 */
abstract class QueryFactory
{
    const TYPE_TERM = 'Term';

    /** @var Container  */
    protected $container;

    /** @var Query\Base */
    protected $query;

    /** @var  Sort\Collection */
    protected $sortCollection;

    public function __construct(Container $container, $query)
    {
        $this->container = $container;
        $this->query = $query;
    }

    public function sortByField($field, $order = null, $mode = null)
    {
        $sort = new Sort\Field();
        $sort = $sort->setField($field);
        $sort = is_null($order) ? $sort->setOrder($order) : $sort;
        $sort = is_null($mode)  ? $sort->setMode($mode)   : $sort;
        $this->container->extend('sortCollection', function ($collection, $c) use ($sort){
            $collection->addSort($sort);
        });

        return $this;
    }

    /**
     * Fetch
     * @param int $from
     * @param int $size
     * @return mixed
     * @throws \tantrum_elastic\Exception\Transport\Client
     * @throws \tantrum_elastic\Exception\Transport\Server
     */
    public function fetch($from = 0, $size = 10)
    {
        $request = new Search();
        $request->setSort($this->container['sortCollection'])
            ->setQuery($this->query)
            ->setSize($size)
            ->setFrom($from);
        $http = new Http($this->container);
        $http->setRequest($request);
        $response = $http->send();
        return $response->getDocuments();
    }

    /**
     * @param $method
     * @param $args
     * @return Query|Base
     */
    public static function __callStatic($type, $args)
    {
        switch($type) {
            // For leaf queries, the queries themselves are are returned for use in a method call
            case 'MatchAll':
            case 'MultiMatch':
            case 'Term':
                return call_user_func_array([self, sprintf('build%sQuery', $type)], $args);
                break;
            // For compound queries,the factory is returned so that they can be extended.
            // Call {Factory}::getElement() to return the query
            case 'Bool':
            case 'Boosting':
            case 'CommonTerms':
                return self::getFactory($type, $this->container);
                break;

        }
    }

    /**
     * Utility method for creating match_all queries
     * @return Query\MatchAll;
     */
    protected function buildMatchAllQuery()
    {
        return new Query\MatchAll();
    }

    /**
     * Utility method for creating multi_match queries
     * @param  string|array $fields
     * @param  mixed $value
     * @throws InvalidArgument
     * @return Query\MultiMatch
     */
    protected function buildMultiMatchQuery($fields, $value)
    {
        $query = new Query\MultiMatch();

        if(is_array($fields)) {
            foreach($fields as $field) {
                $query->addField($field);
            }
        } elseif(is_string($fields)) {
            $query->addField($fields);
        } else {
            throw new InvalidArgument('Multimatch field must be either an array of strings, or a string');
        }

        $query->setValue($value);
    }

    /**
     * Utility method for creating term queries
     * @param $field
     * @param $value
     * @return Query\Term;
     */
    protected function buildTermQuery($field, $value)
    {
        $term = new Query\Term();
        $term->setField($field)
            ->setValue($value);
        return $term;
    }

    /**
     * Get a factory object for a compound query
     * @param $factory
     * @return mixed
     */
    protected function getFactory($factory)
    {
        $factoryName = sprintf('tantrum_elastic\Factory\%s\%s', __NAMESPACE__, $factory);
        return new $factoryName($this->container);
    }

    /**
     * Returns the query
     * @return Query\Base
     */
    public function getQuery()
    {
        return $this->query;
    }
}
