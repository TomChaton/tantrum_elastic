<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Exception;

class MatchAll extends Base
{
    /**
     * Return an array representation of this object
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'match_all' => new \stdClass(),
        ];
    }
}
