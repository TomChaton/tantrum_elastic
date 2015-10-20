<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Lib\Fragment;

class Prefix extends Base
{
    use Fragment\SingleValue;
    use Fragment\SingleField;

    /**
     * @inheritdoc
     */
    protected function process()
    {
        $this->addOption($this->field, $this->value);
        return $this->options;
    }
}

