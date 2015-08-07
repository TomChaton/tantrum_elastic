<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Lib\Fragment;

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
