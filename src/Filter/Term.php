<?php

namespace tantrum_elastic\Filter;
 
use tantrum_elastic\Lib\Fragment;
use tantrum_elastic\Lib\Validate;

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
