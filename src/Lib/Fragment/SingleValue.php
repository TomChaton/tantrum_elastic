<?php

namespace tantrum_elastic\Lib\Fragment;

trait SingleValue
{
    /**
     * A single field value
     * @var mixed
     */
    protected $value;

    /**
     * @param  mixed
     * @return tantrum_elastic\Lib\Element
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
