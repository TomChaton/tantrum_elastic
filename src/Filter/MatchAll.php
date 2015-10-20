<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Exception;

class MatchAll extends Base
{
    /**
     * @inheritdoc
     * @return \stdClass
     */
    protected function process()
    {
        return new \stdClass();
    }
}
