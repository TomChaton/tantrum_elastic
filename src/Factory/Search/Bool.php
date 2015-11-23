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
use tantrum_elastic\Query;
use tantrum_elastic\Query\Bool as BooleanQuery;
use tantrum_elastic\Query\Term;

class Bool extends QueryFactory
{
    /**
     * Provision the boolean query
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container, new BooleanQuery());
        $this->container = $container;
    }

    /**
     * Add a query to the must clause
     * @param Query $query
     * @return $this
     */
    public function must(Query $query)
    {
        $this->query->must($query);
        return $this;
    }
}
