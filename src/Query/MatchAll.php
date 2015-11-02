<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Exception;

/**
 * This class represents the match_all query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.0/query-dsl-match-all-query.html
 * @package tantrum_elastic\Query
 */
class MatchAll extends Base
{
    /**
     * @inheritdoc
     * @return \stdClass
     */
    protected function process()
    {
        return new \stdClass();
    }
}
