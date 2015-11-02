<?php

namespace tantrum_elastic\Query\Lib;

/**
 * This trait adds minimum_should_match functionality to queries
 * @package tantrum_elastic\Query\Lib
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.0/query-dsl-minimum-should-match.html
 */
trait MinimumShouldMatch
{
    /**
     * @param integer $minimumShouldMatch
     * @return $this
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
     * @param $maxValue
     * @param null $message
     * @param null $exceptionClass
     */
    abstract protected function validateMinimumInteger($value, $maxValue, $message = null, $exceptionClass = null);

    /**
     * Ensures that classes using this trait extend Lib\Element
     * @param string $key
     * @param mixed $value
     */

    abstract protected function addOption($key, $value, $isInternal = true);
}
