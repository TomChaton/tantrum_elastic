<?php

namespace tantrum_elastic\Lib\Validate;

trait Strings
{
    /**
     * Validates that the passed value is a string
     * @param  mixed   $string
     * @param  integer $minLength
     * @throws tantrum_elastic\Exception\Validation
     * @return boolean
     */
    protected function validateString($value, $message = 'Value is not a string.', $exceptionClass = 'InvalidString')
    {
        if (!is_string($value)) {
            $namespace = Base::buildExceptionNamespace($exceptionClass);
            throw new $namespace($message);
        }
        
        return true;
    }
}
