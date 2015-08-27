<?php

namespace tantrum_elastic\Query\Lib\CommonTerms;

use tantrum_elastic\Exception\InvalidString;
use tantrum_elastic\Exception\IncompatibleValues;
use tantrum_elastic\Lib\Element;
use tantrum_elastic\Query\Lib\MinimumShouldMatch as MinimumShouldMatchTrait;
use tantrum_elastic\Lib\Validate;

class Body extends Element
{
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
     * @var MinimumShouldMatch
     */
    private $minimumShouldMatchFrequency;

    public function __construct()
    {
        $this->minimumShouldMatchFrequency = new MinimumShouldMatch();
    }

    /**
     * Set the query string
     * @param $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->validateString($query, 'common -> body -> query must be a string');
        $this->validateStringMinimumLength($query, 1, 'common -> body -> query cannot be zero length');
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
        $this->validateFloat($cutoffFrequency, 'common -> body -> cutoff_frequency must be a float');
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
        $this->validateString($lowFreqOperator, 'common -> body -> low_freq_operator must be a string');
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
     * Make sure the query option is not empty
     * @throws InvalidString
     */
    private function validateQuery()
    {
        if (!array_key_exists('query', $this->options)) {
            throw new InvalidString('common -> body -> query cannot be empty');
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
}
