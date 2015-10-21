<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Exception;

/**
 * Class MatchAll
 * @package tantrum_elastic\Query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-match-all-query.html
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
