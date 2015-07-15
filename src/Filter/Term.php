<?php

namespace tantrum_elastic\Filter;
 
use tantrum_elastic\Lib\Fragment;
use tantrum_elastic\Lib\Validate;

class Term extends Base
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
            'term' => [$this->field => $this->value]
        ];
    }
}
