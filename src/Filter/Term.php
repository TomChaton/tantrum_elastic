<?php

namespace tantrum_elastic\Filter;
 
use tantrum_elastic\Lib;
use tantrum_elastic\Lib\Validate;

class Term extends Base
{
    use Traits\SingleValue;
    use Traits\SingleTarget;

    use Validate\Strings;
    use Validate\Arrays;

    /**
     * Add a value to the values array
     * A term only accepts one string value
     * @param string $value
     */
    public function addValue($value)
    {
        $this->validateString($value);
        $this->validateArrayMaximumCount($this->values, 1);
        $this->values[] = $value;
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
     * Prepare the object for formatting
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'term' => [$this->targets[0] => $this->values[0]]
        ];
    }
}
