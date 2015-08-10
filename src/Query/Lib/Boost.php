<?php

namespace tantrum_elastic\Query\Lib;

trait Boost
{
    /**
     * Set the boost value for this query
     * @param $boost
     * @return $this
     */
    public function setBoost($boost)
    {
        $this->validateFloat($boost);
        $this->addOption('boost', $boost);
        return $this;
    }

    /**
     * Ensures that classes using this trait also use the Lib\Validate\Floats trait
     * @param $value
     */
    abstract protected function validateFloat($value, $message = null, $exceptionClass = null);

    /**
     * Ensures that classes using this trait extend Lib\Element
     * @param $value
     */
    abstract protected function addOption($key, $value);
}