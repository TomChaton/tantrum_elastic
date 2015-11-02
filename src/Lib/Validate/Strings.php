<?php

namespace tantrum_elastic\Lib\Validate;

use tantrum_elastic\Exception\Validation;

/**
 * String validation methods
 * @package tantrum_elastic\Lib\Validate
 */
trait Strings
{
    /**
     * Validates that the passed value is a string
     * @param  mixed  $value
     * @param  string $message        - Optional custom error message to throw
     * @param  string $exceptionClass - Optional namespaced (relative to Exception) exception class to throw
     * 
     * @throws Validation
     * 
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
