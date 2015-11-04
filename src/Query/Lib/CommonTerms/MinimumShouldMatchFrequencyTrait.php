<?php
/**
 * This file is part of tantrum_elastic.
 *
 *  tantrum_elastic is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  tantrum_elastic is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with tatrum_elastic.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace tantrum_elastic\Query\Lib\CommonTerms;

/**
 * This trait gives the minimum_should_match object in the common terms query its functionality
 * @package tantrum_elastic\Query\Lib\CommonTerms
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.0/query-dsl-common-terms-query.html#_examples_3
 */
trait MinimumShouldMatchFrequencyTrait
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
