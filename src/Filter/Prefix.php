<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Lib\Fragment;

class Prefix extends Base
{
    use Fragment\SingleValue;
    use Fragment\SingleField;

    /**
     * Prepare the object for formatting
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'prefix' => [$this->field => $this->value]
        ];
    }
}

