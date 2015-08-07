<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Lib\Fragment;

class Term extends Base
{
    use Fragment\SingleField;
    use Fragment\SingleValue;

    /**
     * @inheritdoc
     * @return array
     */
    protected function process()
    {
        return ['term' => [$this->field => $this->value]];
    }
}
