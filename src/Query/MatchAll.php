<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Exception;

class MatchAll extends Base
{
    /**
     * @param  array $values
     * @throws tantrum_elastic\Exception\NotSupported
     */
    public function setValues(array $values)
    {
        throw new Exception\NotSupported('The match all query does not accept values.');
    }

    /**
     * @param  mixed $value
     * @throws tantrum_elastic\Exception\\NotSupported
     */
    public function addValue($value)
    {
        throw new Exception\NotSupported('The match all query does not accept values.');
    }

    /**
     * @param  array $values
     * @throws tantrum_elastic\Exception\\NotSupported
     */
    public function setTargets(array $targets)
    {
        throw new Exception\NotSupported('The match all query does not accept targets.');
    }

    /**
     * @param  mixed $value
     * @throws tantrum_elastic\Exception\\NotSupported
     */
    public function addTarget($target)
    {
        throw new Exception\NotSupported('The match all query does not accept targets.');
    }

    /**
     * Return an array representation of this object
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'match_all' => new \stdClass(),
        ];
    }
}
