<?php

namespace tantrum_elastic\Filter;

class MatchAll extends Base
{
    /**
     * Return a json serializable representation of the object
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'match_all' => new \stdClass(),
        ];
    }
}
