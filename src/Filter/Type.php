<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Lib\Fragment;

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

