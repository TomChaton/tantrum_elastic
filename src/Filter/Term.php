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
     * A term only accepts one value
     * @param mixed $value
     */
    public function addValue($value)
    {
        $this->validateArrayMaximumCount($this->values, 0);
        $this->values[] = $value;
    }

    /**
     * Add a value to the data array
     * A term only accepts one string value
     * @param mixed $value
     */
    public function addTarget($target)
    {
        $this->validateArrayMaximumCount($this->targets, 0);
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
