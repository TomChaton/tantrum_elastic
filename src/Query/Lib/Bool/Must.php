<?php

namespace tantrum_elastic\Query\Lib\Bool;

use tantrum_elastic\Query\Lib\ClauseCollection;

/**
 * @inheritdoc
 * This class gives the bool query the ability to contain multiple queries inside a "not" element
 * @package tantrum_elastic\Query\Lib\Bool
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-bool-query.html
 */
class Must extends ClauseCollection
{
}
