<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Exception;

trait SingleValue
{
    /**
     * @param  array $values
     * @throws tantrum_elastic\Exception\NotSupported
     */
    public function setValues(array $values)
    {
        throw new Exception\NotSupported('This element does not accept multiple values.');
    }
}
