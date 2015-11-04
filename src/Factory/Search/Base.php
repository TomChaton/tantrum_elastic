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
use tantrum_elastic\Request\Search;
use tantrum_elastic\Sort;
use tantrum_elastic\Query;
use tantrum_elastic\Transport\Http;

/**
 * Base class for all search factory classes
 * @package tantrum_elastic\Factory\Search
 */
abstract class Base
{
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
}
