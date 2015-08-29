<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Lib\Fragment;
use tantrum_elastic\Lib\Validate;

class Type extends Base
{
    use Fragment\SingleValue;

    /**
     * Prepare the object for formatting
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'type' => ['value' => $this->value]
        ];
    }
}

