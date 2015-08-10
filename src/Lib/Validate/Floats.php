<?php

namespace tantrum_elastic\Lib\Validate;

use tantrum_elastic\Exception\Validation;

trait Floats
{

    public function validateFloat($value, $message = 'Vakue is not a float', $exceptionClass = 'InvalidFloat')
    {
        if (!is_float($value)) {
            $namespace = Base::buildExceptionNamespace($exceptionClass);
            throw new $namespace($message);
        }

        return true;
    }
}
