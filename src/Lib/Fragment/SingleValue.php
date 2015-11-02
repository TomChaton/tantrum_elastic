<?php

namespace tantrum_elastic\Lib\Fragment;

use tantrum_elastic\Lib\Element;

/**
 * This trait provides a single value for field / value pairs inside elements
 * @package tantrum_elastic\Lib\Fragment
 */
trait SingleValue
{
    /**
     * A single field value
     * @var mixed
     */
    protected $value;

    /**
     * Set the value for this object
     * @param  mixed
     * @return Element
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
