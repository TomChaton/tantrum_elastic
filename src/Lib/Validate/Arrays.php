<?php

namespace tantrum_elastic\Lib\Validate;

trait Arrays
{
    /**
     * Validate
     * @param  mixed $value
     * @throws Exception\InvalidArray
     * @return boolean
     */
    protected function validateArray($value)
    {
        if (!is_array($value)) {
            Base::handleValidationError('Value is not an array', 'InvalidArray');
        }
        return true;
    }

    /**
     * Validate that the size of the array is within the provided parameters
     * @param  mixed   $value
     * @param  integer $minSize
     * @param  integer $maxSize
     * @throws Exception\InvalidArray
     * @return boolean
     */
    protected function validateArrayCount($value, $minSize, $maxSize)
    {
        $this->validateArray($value);
        $this->validateArrayMinimumCount($value, $minSize);
        $this->validateArrayMaximumCount($value, $maxSize);

        return true;
    }

    /**
     * Validate that the size of the array is above or equal to the minimum size provided
     * @param  mixed   $value
     * @param  integer $minSize
     * @throws Exception\InvalidArray
     * @return boolean
     */
    protected function validateArrayMinimumCount($value, $minSize)
    {
        $this->validateArray($value);
        if(count($value) < $minSize) {
            Base::handleValidationError("Array is smaller than $minSize", 'InvalidArray');
        } 

        return true;
    }

    /**
     * Validate that the size of the array is below or equal to the maximum size provided
     * @param  mixed   $value
     * @param  integer $maxSize
     * @throws Exception\InvalidArray
     * @return boolean
     */
    protected function validateArrayMaximumCount($value, $maxSize)
    {
        $this->validateArray($value);
        if (count($value) > $maxSize) {
            Base::handleValidationError("Array is larger than $maxSize", 'InvalidArray');
        }

        return true;
    }
}