<?php

namespace tantrum_elastic\Lib\Validate;

trait Integers
{
    /**
     * Validates that the provided value is an integer
     * @param  mixed $value
     * @throws tantrum_elastic\Exception\Validation
     * @return boolean
     */
    public function validateInteger($value, $message = 'Value is not an integer', $exceptionClass = 'InvalidInteger')
    {
        if (!is_int($value)) {
            $namespace = Base::buildExceptionNamespace($exceptionClass);
            throw new $namespace($message);
        }

        return true;
    }

    /**
     * Validates that the provided value is within the specified range
     * @param  mixed $value
     * @param  integer $minRange
     * @param  integer $maxRange
     * @throws tantrum_elastic\Exception\Validation
     * @return boolean
     */
    public function validateIntegerRange($value, $minValue, $maxValue, $message = 'Integer is not within range', $exceptionClass = 'InvalidInteger')
    {
        $this->validateMinimumInteger($value, $minValue, $message, $exceptionClass);
        $this->validateMaximumInteger($value, $maxValue, $message, $exceptionClass);
        
        return true;
    }

    /**
     * Validates that the provided value is not lower than the specified minimum value
     * @param  mixed $value
     * @param  integer $minValue
     * @throws tantrum_elastic\Exception\Validation
     * @return boolean
     */
    public function validateMinimumInteger($value, $minValue, $message = 'Value is less than %d', $exceptionClass = 'InvalidInteger')
    {
        $this->validateInteger($minValue);
        if ($value < $minValue) {
            $namespace = Base::buildExceptionNamespace($exceptionClass);
            throw new $namespace(sprintf($message, $minValue));
        }

        return true;
    }

    /**
     * Validates that the provided value is not higher than the specified maximum value
     * @param  mixed $value
     * @param  integer $maxValue
     * @throws tantrum_elastic\Exception\Validation
     * @return boolean
     */
    public function validateMaximumInteger($value, $maxValue, $message = 'Value is greater than %d', $exceptionClass = 'InvalidInteger')
    {
        $this->validateInteger($maxValue);
        if ($value > $maxValue) {
            $namespace = Base::buildExceptionNamespace($exceptionClass);
            throw new $namespace(sprintf($message, $maxValue));
        }

        return true;
    }
}
