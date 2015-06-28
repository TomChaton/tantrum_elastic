<?php

namespace tantrum_elastic\Lib\Validate;

trait Integers 
{
    /**
     * Validates that the provided value is an integer
     * @param  mixed $value
     * @throws InvalidInteger
     * @return boolean
     */
    public function validateInteger($value)
    {
        if (!is_int($value)) {
            Base::handleValidationError('Value is not an integer', 'InvalidInteger');
        }

        return true;
    }

    /**
     * Validates that the provided value is within the specified range
     * @param  mixed $value
     * @param  integer $minRange
     * @param  integer $maxRange
     * @throws InvalidInteger
     * @return boolean
     */
    public function validateIntegerRange($value, $minRange, $maxRange)
    {
        $this->validateInteger($value);
        $this->validateMinimumInteger($value, $minRange);
        $this->validateMaximumInteger($value, $maxRange);
        
        return true;
    }

    /**
     * Validates that the provided value is not lower than the specified minimum value
     * @param  mixed $value
     * @param  integer $minValue
     * @throws InvalidInteger
     * @return boolean
     */
    public function validateMinimumInteger($value, $minValue)
    {
        $this->validateInteger($value);
        $this->validateInteger($minValue);
        if ($value < $minValue) {
            Base::handleValidationError("Value is less than $minRange", 'InvalidInteger');
        }

        return true;
    }

    /**
     * Validates that the provided value is not higher than the specified maximum value
     * @param  mixed $value
     * @param  integer $maxValue
     * @throws InvalidInteger
     * @return boolean
     */
    public function validateMaximumInteger($value, $maxValue)
    {
        $this->validateInteger($value);
        $this->validateInteger($maxValue);
        if ($value > $maxValue) {
            Base::handleValidationError("Value is greater than $maxRange", 'InvalidInteger');
        }

        return true;
    }
}