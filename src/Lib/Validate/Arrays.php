<?php

namespace tantrum_elastic\Lib\Validate;

use tantrum_elastic\Exception;

trait Arrays
{
    /**
     * Validate
     * @param  mixed  $value
     * @param  string $message
     * @param  string $exceptionClass
     * @throws tantrum_elastic\Exception\General
     * @return boolean
     */
    protected function validateArray($value, $message = null, $exceptionClass = null)
    {
        if (!is_array($value)) {
            Base::handleValidationError(
                is_null($message) ? 'Value is not an array' : $message,
                is_null($exceptionClass) ? 'InvalidArray' : $exceptionClass
            );
        }
        return true;
    }

    /**
     * Validate that the size of the array is within the provided parameters
     * @param  mixed   $value
     * @param  integer $minSize
     * @param  integer $maxSize
     * @param  string  $message
     * @param  string  $exceptionClass
     * @throws tantrum_elastic\Exception\General
     * @return boolean
     */
    protected function validateArrayCount(array $array, $minSize, $maxSize, $message = null, $exceptionClass = null)
    {
        $this->validateArrayMinimumCount($array, $minSize, $message, $exceptionClass);
        $this->validateArrayMaximumCount($array, $maxSize, $message, $exceptionClass);

        return true;
    }

    /**
     * Validate that the size of the array is above or equal to the minimum size provided
     * @param  mixed   $value
     * @param  integer $minSize
     * @param  string  $message
     * @param  string  $exceptionClass
     * @throws tantrum_elastic\Exception\General
     * @return boolean
     */
    protected function validateArrayMinimumCount(array $array, $minSize, $message = null, $exceptionClass = null)
    {
        if (count($array) < $minSize) {
            Base::handleValidationError(
                is_null($message) ? "Array is smaller than $minSize" : $message,
                is_null($exceptionClass) ? 'InvalidArray' : $exceptionClass
            );
        }

        return true;
    }

    /**
     * Validate that the size of the array is below or equal to the maximum size provided
     * @param  array   $array
     * @param  integer $maxSize
     * @param  string  $message
     * @param  string  $exceptionClass
     * @throws tantrum_elastic\Exception\General
     * @return boolean
     */
    protected function validateArrayMaximumCount(array $array, $maxSize, $message = null, $exceptionClass = null)
    {
        if (count($array) > $maxSize) {
            Base::handleValidationError(
                is_null($message) ? "Array is larger than $maxSize" : $message,
                is_null($exceptionClass) ? 'InvalidArray' : $exceptionClass
            );
        }

        return true;
    }

    /**
     * Validates that an array key does not exist
     * @param  array          $array
     * @param  integer|string $key
     * @param  string         $message
     * @param  string         $exceptionClass
     * @throws tantrum_elastic\Exception\General
     * @return boolean
     */
    protected function validateKeyIsNotInArray(array $array, $key, $message = null, $exceptionClass = null)
    {

    }
}
