<?php

namespace tantrum_elastic\Lib\Validate;

trait Strings
{
    /**
     * Validates that the passed value is a string
     * @param  mixed   $string
     * @param  integer $minLength
     * @throws tantrum_elastic\Exception\InvalidString
     * @return boolean
     */
    protected function validateString($value)
    {
        if (!is_string($value)) {
            Base::handleValidationFailure('Value is not a string', 'InvalidString');
        }
        
        return true;
    }

    /**
     * Validates that the provided string exists as a value in the provided array
     * @param  string $value
     * @param  array  $array
     * @throws tantrum_elastic\Exception\InvalidString
     * @return boolean
     */
    protected function validateStringIsInArray($value, array $array)
    {
        $this->validateString($value);
        if (!in_array($value, $array)) {
            Base::handleValidationFailure(sprintf('Value "%s" does not exist in array %s', $value, print_r($array, 1)), 'InvalidString');
        }

        return true;
    }
}
