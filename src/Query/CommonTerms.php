<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Lib\Validate;
use tantrum_elastic\Query\Lib\MinimumShouldMatch;
use tantrum_elastic\Query\Lib\CommonTerms as Lib;

/**
 * This class is responsible for provisioning and rendering the common terms query
 * @package tantrum_elastic\Query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-common-terms-query.html
 */
class CommonTerms extends Base
{

    /**
     * @var Lib\Body
     */
    private $body;

    /**
     * Create a body element
     */
    public function __construct()
    {
        $this->body = new Lib\Body();
    }

    /**
     * Set the query text
     * @param  $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->body->setQuery($query);
        return $this;
    }

    /**
     * Set the minimum_should_match value for high frequency terms
     * @param  integer $frequency
     * @return $this
     */
    public function setHighFreq($frequency)
    {
        $this->body->setHighFreq($frequency);
        return $this;
    }

    /**
     * Set the minimum_should_match value for low frequency terms
     * @param  integer $frequency
     * @return $this
     */
    public function setLowFreq($frequency)
    {
        $this->body->setLowFreq($frequency);
        return $this;
    }

    /**
     * Set the minimum should match value
     * @link https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-minimum-should-match.html
     *
     * @param  mixed $minimumShouldMatch
     * @return $this
     */
    public function setMinimumShouldMatch($minimumShouldMatch)
    {
        $this->body->setMinimumShouldMatch($minimumShouldMatch);
        return $this;
    }

    /**
     * Set the cutoff frequency
     * @param  float $frequency
     * @return $this
     */
    public function setCutoffFrequency($frequency)
    {
        $this->body->setCutoffFrequency($frequency);
        return $this;
    }

    /**
     * Set the low frequency operator
     * @param string $operator
     * @return this
     */
    public function setLowFreqOperator($operator)
    {
        $this->body->setLowFreqOperator($operator);
        return $this;
    }

    public function process()
    {
        $this->addElement($this->body);
        return $this->elements;
    }

    public function getElementName()
    {
        return 'common';
    }
}
