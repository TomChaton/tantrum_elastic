<?php

namespace tantrum_elastic\Query\Lib;

use tantrum_elastic\Exception\IncompatibleValues;

/**
 * Trait MinimumShouldMatch
 * @package tantrum_elastic\Query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-minimum-should-match.html
 */
trait MinimumShouldMatch
{
    /**
     * Set the minimum should match value
     *
     * @param  mixed $minimumShouldMatch
     * @return $this
     */
    public function setMinimumShouldMatch($minimumShouldMatch)
    {
        // @Todo: This validation is too strict. certain string formats are allowed here
        $this->validateMinimumInteger($minimumShouldMatch, 1, 'minimum_should_match must be a positive integer');
        $this->addOption('minimum_should_match', $minimumShouldMatch);
        return $this;
    }

    /**
     * Ensures that classes using this trait also use the Lib\Validate\Integers trait
     * @param $value
     * @param $maxValue
     * @param string $message
     * @param string $exceptionClass
     * @return bool
     */
    abstract protected function validateMinimumInteger($value, $maxValue, $message = null, $exceptionClass = null);

    /**
     * Ensures that classes using this trait extend Lib\Element
     * @param string  $key
     * @param mixed   $value
     * @param boolean $isInternal
     */
    abstract protected function addOption($key, $value, $isInternal = true);
}
