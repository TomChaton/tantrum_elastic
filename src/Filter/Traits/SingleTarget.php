<?php

namespace tantrum_elastic\Filter\Traits;

use tantrum_elastic\Exception;

trait SingleTarget
{
    /**
     * @param  array $values
     * @throws tantrum_elastic\Exception\NotSupported
     */
    public function setTargets(array $targets)
    {
        throw new Exception\NotSupported('This element does not accept multiple targets.');
    }
}
