<?php

namespace tantrum_elastic\Query\Lib\Boosting;

use tantrum_elastic\Query\Lib\ClauseCollection;

/**
 * @inheritdoc
 * This class gives the boosting query the ability to contain multiple queries inside a "negative" element
 * @package tantrum_elastic\Query\Lib\Boosting
 * https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-boosting-query.html
 */
class Negative extends ClauseCollection
{
}
