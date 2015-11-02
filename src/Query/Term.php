<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Lib\Fragment;

/**
 * This class represents the term query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.0/query-dsl-term-query.html
 * @package tantrum_elastic\Query
 */
class Term extends Base
{
    use Fragment\SingleField;
    use Fragment\SingleValue;

    /**
     * @inheritdoc
     */
    protected function preProcess()
    {
        $this->addOption($this->field, $this->value);
    }
}
