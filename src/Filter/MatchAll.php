<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Exception;

class MatchAll extends Base
{
    /**
     * Return a json serializable representation of the object
     * @return array
     */
    final public function jsonSerialize()
    {
        return [
            'match_all' => new \stdClass(),
        ];
    }
}
