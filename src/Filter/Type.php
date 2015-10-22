<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Lib\Fragment;

/**
 * This class is responsible for provisioning and rendering the type filter
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-type-filter.html
 * @package tantrum_elastic\Filter
 */
class Type extends Base
{
    use Fragment\SingleValue;

    /**
     * @inheritdoc
     */
    public function preProcess()
    {
        $this->addOption('value', $this->value);
    }
}

