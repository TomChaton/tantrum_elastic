<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Lib\Fragment;

/**
 * This class is responsible for provisioning and rendering the prefix filter
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-prefix-filter.html
 * @package tantrum_elastic\Filter
 */
class Prefix extends Base
{
    use Fragment\SingleValue;
    use Fragment\SingleField;

    /**
     * @inheritdoc
     */
    protected function preProcess()
    {
        $this->addOption($this->field, $this->value);
    }
}

