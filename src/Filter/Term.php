<?php

namespace tantrum_elastic\Filter;
 
use tantrum_elastic\Lib\Fragment;
use tantrum_elastic\Lib\Validate;

/**
 * This class is responsible for provisioning and rendering the term filter
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-term-filter.html
 * @package tantrum_elastic\Filter
 */
class Term extends Base
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
