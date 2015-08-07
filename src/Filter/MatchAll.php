<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Exception;

class MatchAll extends Base
{
    /**
     * @return array
     */
    protected function process()
    {
        return ['match_all' => new \stdClass()];
    }
}
