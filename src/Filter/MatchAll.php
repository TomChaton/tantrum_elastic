<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Exception;

class MatchAll extends Base
{
    /**
     * @param  array $values
     * @throws Exception\NotSupported
     */
    public function setValues(array $values)
    {
        throw new Exception\NotSupported('The match all filter does not accept values.');
    }

    /**
     * @param  mixed $value
     * @throws Exception\NotSupported
     */
    public function addValue($value)
    {
        throw new Exception\NotSupported('The match all filter does not accept values.');
    }

    /**
     * @param  array $values
     * @throws Exception\NotSupported
     */
    public function setTargets(array $targets)
    {
        throw new Exception\NotSupported('The match all filter does not accept targets.');
    }

    /**
     * @param  mixed $value
     * @throws Exception\NotSupported
     */
    public function addTarget($target)
    {
        throw new Exception\NotSupported('The match all filter does not accept targets.');
    }

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
