<?php

namespace tantrum_elastic\Query\Lib;

/**
 * Trait MinimumShouldMatchFrequency
 * @package tantrum_elastic\Query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-minimum-should-match.html
 */
trait MinimumShouldMatchFrequency
{
    /**
     * Set the minimum_should_match value for low frequency terms
     * @param  integer $frequency
     * @return $this;
     */
    public function setLowFreq($frequency)
    {
        $this->validateMinimumInteger($frequency, 1, 'low_freq must be a positive integer');
        $this->addOption('low_freq', $frequency);
        return $this;
    }

    /**
     * Set the minimum_should_match value for high frequency terms
     * @param  integer $frequency
     * @return $this
     */
    public function setHighFreq($frequency)
    {
        $this->validateMinimumInteger($frequency, 1, 'high_freq must be a positive integer');
        $this->addOption('high_freq', $frequency);
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
