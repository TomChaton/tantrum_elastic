<?php

namespace tantrum_elastic\Lib\Validate;

use tantrum_elastic\Exception\Validation;

/**
* This trait contains float validation methods
* @package tantrum_elastic\Lib\Validate
* @internal
*/
trait Floats
{

    /**
     * Validates that the supplied value is a floating point number
     * @param $value
     * @param string $message
     * @param string $exceptionClass
     * @return bool
     */
    public function validateFloat($value, $message = 'Value is not a float', $exceptionClass = 'InvalidFloat')
    {
        if (!is_float($value)) {
            $namespace = Base::buildExceptionNamespace($exceptionClass);
            throw new $namespace($message);
        }

        return true;
    }
}
