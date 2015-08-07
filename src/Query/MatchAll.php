<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Exception;

class MatchAll extends Base
{
    /**
     * @inheritdoc
     * @return array
     */
    protected function process()
    {
        return ['match_all' => new \stdClass()];
    }
}
