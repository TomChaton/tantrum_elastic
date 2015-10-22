<?php

namespace tantrum_elastic\Lib\Fragment;

/**
 * This trait provides a single field for field / value(s) pairs inside elements
 * @package tantrum_elastic\Lib\Fragment
 */
trait SingleField
{
    /**
     * A single field name
     * @var mixed
     */
    protected $field;

    /**
     * Set the field name for this object
     * @param  mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }
}
