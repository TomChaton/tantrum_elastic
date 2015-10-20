<?php

namespace tantrum_elastic\Query;

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
