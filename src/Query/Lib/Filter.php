<?php

namespace tantrum_elastic\Query\Lib;

use tantrum_elastic\Query\Lib\ClauseCollection;
use tantrum_elastic\Query\Base;

/**
 * This class adds a filter element onto compund queries such as bool and common_terms
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.x/query-dsl-bool-query.html
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.x/query-filter-context.html
 * @package tantrum_elastic\Query\Lib
 */
class Filter extends ClauseCollection
{
}
