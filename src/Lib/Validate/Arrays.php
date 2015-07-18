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
     * @throws tantrum_elastic\Exception\Validation
     * @return boolean
     */
    protected function validateArray($value, $message = 'Value is not an array', $exceptionClass = 'InvalidArray')
    {
        if (!is_array($value)) {
            $namespace = Base::buildExceptionNamespace($exceptionClass);
            throw new $namespace($message);
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
     * @throws tantrum_elastic\Exception\Validation
     * @return boolean
     */
    protected function validateArrayCount(array $array, $minSize, $maxSize, $message = null, $exceptionClass = 'InvalidArray')
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
     * @throws tantrum_elastic\Exception\Validation
     * @return boolean
     */
    protected function validateArrayMinimumCount(array $array, $minSize, $message = 'Array is smaller than %d', $exceptionClass = 'InvalidArray')
    {
        if (count($array) < $minSize) {
            $namespace = Base::buildExceptionNamespace($exceptionClass);
            throw new $namespace(sprintf($message, $minSize));
        }

        return true;
    }

    /**
     * Validate that the size of the array is below or equal to the maximum size provided
     * @param  array   $array
     * @param  integer $maxSize
     * @param  string  $message
     * @param  string  $exceptionClass
     * @throws tantrum_elastic\Exception\Validation
     * @return boolean
     */
    protected function validateArrayMaximumCount(array $array, $maxSize, $message = 'Array is larger than %d', $exceptionClass = 'InvalidArray')
    {
        if (count($array) > $maxSize) {
            $namespace = Base::buildExceptionNamespace($exceptionClass);
            throw new $namespace(sprintf($message, $maxSize));
        }

        return true;
    }

    /**
     * Validates that the provided value exists as a value in the provided array
     * @param  string $value
     * @param  array  $array
     * @throws tantrum_elastic\Exception\Validation
     * @return boolean
     */
    protected function validateValueExistsInArray($value, array $array, $message = 'Value "%s" does not exist in array %s', $exceptionClass = 'ArrayValueNotFound')
    {
        if (!in_array($value, $array)) {
            $namespace = Base::buildExceptionNamespace($exceptionClass);
            throw new $namespace(sprintf($message, $value, print_r($array, 1)));
        }

        return true;
    }
}
