<?php

namespace tantrum_elastic\Lib\Fragment;

trait SingleField
{
    /**
     * A single field name
     * @var integer|string
     */
    protected $field;

    /**
     * @param  array $values
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }
}
