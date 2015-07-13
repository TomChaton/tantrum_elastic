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
    protected function validateString($value, $message = null, $exceptionClass = null)
    {
        if (!is_string($value)) {
            Base::handleValidationError(
                is_null($message) ? 'Value is not a string' : $message,
                is_null($exceptionClass) ? 'InvalidString' : $exceptionClass
            );
        }
        
        return true;
    }

    /**
     * Validates that the provided string exists as a key or value in the provided array
     * @param  string $value
     * @param  array  $array
     * @throws tantrum_elastic\Exception\Validation
     * @return boolean
     */
    protected function validateStringIsInArray($value, array $array, $message = null, $exceptionClass = null)
    {
        if (!in_array($value, $array)) {
            Base::handleValidationError(
                is_null($message) ? sprintf('Value "%s" does not exist in array %s', $value, print_r($array, 1)) : $message,
                is_null($exceptionClass) ? 'InvalidString' : $exceptionClass
            );
        }

        return true;
    }
}
