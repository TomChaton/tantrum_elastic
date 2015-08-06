<?php

namespace tantrum_elastic\Query\Lib;

trait MinimumShouldMatch
{
    /**
     * @param integer $minimumShouldMatch
     */
    public function setMinimumShouldMatch($minimumShouldMatch)
    {
        $this->validateMinimumInteger($minimumShouldMatch, 1, 'minimum _should_match must be a positive integer');
        $this->addOption('minimum_should_match', $minimumShouldMatch);
        return $this;
    }

    /**
     * Ensures that classes using this trait also use the Lib\Validate\Integers trait
     * @param $value
     */
    abstract protected function validateMinimumInteger($value, $maxValue, $message = null, $exceptionClass = null);

    /**
     * Ensures that classes using this trait extend Lib\Element
     * @param $value
     */
    abstract protected function addOption($key, $value);
}