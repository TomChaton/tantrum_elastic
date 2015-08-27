<?php

namespace tantrum_elastic\Lib\Validate;

use tantrum_elastic\Exception\Validation;

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
    protected function validateStringMinimumLength($value, $minimumLength = 1, $message = 'String cannot be shorter than %d.', $exceptionClass = 'InvalidString')
    {
        if (strlen(trim($value)) < $minimumLength) {
            $namespace = Base::buildExceptionNamespace($exceptionClass);
            throw new $namespace(sprintf($message, $minimumLength));
        }

        return true;
    }
}
