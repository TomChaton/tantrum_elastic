<?php

namespace tantrum_elastic\Lib\Fragment;

trait MultipleField
{
    protected $fields = [];

    /**
     * Add a field to the array
     * @param string $field
     * @return $this
     */
    public function addField($field)
    {
        $this->validateString($field);
        $this->fields[] = $field;
        return $this;
    }

    /**
     * Ensures that classes using this trait also use the Lib\Validate\Strings trait
     * @param $value
     */
    abstract protected function validateString($value, $message = null, $exceptionClass = null);
}