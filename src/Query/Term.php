<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Lib\Fragment;

/**
 * This class is responsible for provisioning and rendering the term query object
 * @package tantrum_elastic\Query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-term-query.html
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
