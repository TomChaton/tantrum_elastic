<?php

namespace tantrum_elastic\Lib\Fragment;

trait SingleField
{
    /**
     * A single field name
     * @var mixed
     */
    protected $field;

    /**
     * @param  mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }
}
