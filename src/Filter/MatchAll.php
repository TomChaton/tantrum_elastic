<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Exception;

/**
 * This class is responsible for provisioning and rendering the match_all filter
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-match-all-filter.html
 * @package tantrum_elastic\Filter
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
