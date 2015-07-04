<?php

namespace tantrum_elastic\Filter;

use tantrum_elastic\Lib;
use tantrum_elastic\Lib\Validate;

class Term extends Filter
{
    use Validate\Strings;
    use Validate\Arrays;

    /**
     * Add a value to the data array
     * A term only accepts one string value
     * @param string $value
     */
    public function addValue($value)
    {
        $this->validateString($value);
        $this->validateArrayMaximumCount($this->data, 1);
        $this->data[] = $value;
    }

    /**
     * @param  array $values
     * @throws Exception\NotSupported
     */
    public function setValues(array $values)
    {
        throw new Exception\NotSupported('Term elements do not support an array of values. Try using a Terms element instead');
    }

    /**
     * Add a value to the data array
     * A term only accepts one string value
     * @param string $value
     */
    public function addTarget($target)
    {
        $this->validateString($target);
        $this->validateArrayMaximumCount($this->targets, 1);
        $this->targets[] = $target;
    }

    /**
     * @param  array $values
     * @throws Exception\NotSupported
     */
    public function setTargets(array $targets)
    {
        throw new Exception\NotSupported('Term elements do not support an array of targets.');
    }

    /**
     * Prepare the object for formatting
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'term' => [$this->targets[0] => $this->data[0]]
        ];
    }
}
