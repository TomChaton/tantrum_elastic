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

use Interop\Container\ContainerInterface;
use tantrum_elastic\Exception\InvalidString;
use tantrum_elastic\Exception\IncompatibleValues;
use tantrum_elastic\Lib\Element;
use tantrum_elastic\Lib\Fragment\SingleField;
use tantrum_elastic\Query\Lib\MinimumShouldMatchTrait;
use tantrum_elastic\Lib\Validate;
use tantrum_elastic\Query\Lib\CommonTerms\MinimumShouldMatch as MinimumShouldMatchFrequency;

/**
 * This class is responsible for provisioning and rendering the body element of the common terms query
 * @package tantrum_elastic\Query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.0/query-dsl-common-terms-query.html
 */
class Field extends Element
{
    use SingleField;
    use MinimumShouldMatchTrait;
    use Validate\Strings;
    use Validate\Arrays;
    use Validate\Floats;
    use Validate\Integers;

    const OPERATOR_AND = 'and';
    const OPERATOR_OR  = 'or';

    private static $allowedOperators = [
        self::OPERATOR_AND,
        self::OPERATOR_OR,
    ];

    /**
     * @var MinimumShouldMatchFrequency
     */
    private $minimumShouldMatchFrequency;

    /**
     * Provision a minimum should match frequency object.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->minimumShouldMatchFrequency = $this->make('tantrum_elastic\Query\Lib\CommonTerms\MinimumShouldMatch');
    }

    /**
     * Set the query string
     * @param $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->validateString($query, 'common terms: query must be a string');
        $this->validateStringMinimumLength($query, 1, 'common terms: query cannot be zero length');
        $this->addOption('query', $query);
        return $this;
    }

    /**
     * Set the cutoff frequency
     * @param $cutoffFrequency
     * @return $this
     */
    public function setCutoffFrequency($cutoffFrequency)
    {
        $this->validateFloat($cutoffFrequency, 'common terms: cutoff_frequency must be a float');
        $this->addOption('cutoff_frequency', $cutoffFrequency);
        return $this;
    }

    /**
     * Set the low frequency operator
     * @param $lowFreqOperator
     * @return $this
     */
    public function setLowFreqOperator($lowFreqOperator)
    {
        $this->validateString($lowFreqOperator, 'common terms: low_freq_operator must be a string');
        $this->validateValueExistsInArray($lowFreqOperator, self::$allowedOperators, sprintf('Operator must be one of "%s"', implode('|', self::$allowedOperators)), 'InvalidArgument');
        $this->addOption('low_freq_operator', $lowFreqOperator);
        return $this;
    }

    /**
     * Set the minimum_should_match value for high frequency terms
     * @param  integer $frequency
     * @return $this
     */
    public function setHighFreq($frequency)
    {
        $this->minimumShouldMatchFrequency->setHighFreq($frequency);
        return $this;
    }

    /**
     * Set the minimum_should_match value for low frequency terms
     * @param  integer $frequency
     * @return $this
     */
    public function setLowFreq($frequency)
    {
        $this->minimumShouldMatchFrequency->setLowFreq($frequency);
        return $this;
    }

    /**
     * Validate the values we have
     */
    protected function validate()
    {
        $this->validateFieldName();
        $this->validateQuery();
        $this->validateMinimumShouldMatch();
    }

    /**
     * Add minimumShouldMatch frequency object if it is not empty
     */
    protected function preProcess()
    {
        if (!$this->minimumShouldMatchFrequency->isEmpty()) {
            $this->addElement($this->minimumShouldMatchFrequency);
        }
    }

    /**
     * Make sure the field name is not empty
     */
    private function validateFieldName()
    {
        $this->validateStringMinimumLength($this->field, 1, 'common terms: query cannot be zero length');
    }

    /**
     * Make sure the query option is not empty
     * @throws InvalidString
     */
    private function validateQuery()
    {
        if (!array_key_exists('query', $this->options)) {
            throw new InvalidString('common terms: query cannot be empty');
        }
    }

    /**
     * Make sure we have not set minimum_should_match and low_freq / high_freq
     * @throws IncompatibleValues
     */
    private function validateMinimumShouldMatch()
    {
        $minimumShouldMatch = array_key_exists('minimum_should_match', $this->options);
        $minimumShouldMatchFrequency = !$this->minimumShouldMatchFrequency->isEmpty();
        if ($minimumShouldMatch === true && $minimumShouldMatchFrequency === true) {
            throw new IncompatibleValues('minimum_should_match and low_freq / high_freq are incompatible. Please refer to the manual');
        }
    }

    public function getElementName()
    {
        return $this->field;
    }
}
