<?php

namespace tantrum_elastic\Query;

class MatchAll extends Base
{
    public function jsonSerialize()
    {
        return [
            'match_all' => new \stdClass(),
        ];
    }
}