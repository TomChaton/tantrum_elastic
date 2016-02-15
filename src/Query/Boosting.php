<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Query\Lib\Boosting\Positive;
use tantrum_elastic\Query\Lib\Boosting\Negative;
use tantrum_elastic\Lib\Validate;

/**
 * This class represents the boosting query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.0/query-dsl-boosting-query.html
 * @package tantrum_elastic\Query
 */
class Boosting extends Base
{
    use Validate\Floats;

    /**
     * @var Positive
     */
    private $positive;

    /**
     * @var Negative
     */
    private $negative;

    /**
     * Return the positive collection. Create one if it doesn't exist
     *
     * @return Positive
     */
    private function getPositive()
    {
        if (is_null($this->positive)) {
            $this->positive = $this->make('tantrum_elastic\Query\Lib\Boosting\Positive');
            $this->addElement($this->positive);
        }
        return $this->positive;
    }

    /**
     * Return the negative collection. Create one if it doesn't exist
     *
     * @return Negative
     */
    private function getNegative()
    {
        if (is_null($this->negative)) {
            $this->negative = $this->make('tantrum_elastic\Query\Lib\Boosting\Negative');
            $this->addElement($this->negative);
        }
        return $this->negative;
    }

    /**
     * Add a positive query
     * @param Base $query
     * @return $this
     */
    public function addPositive(Base $query)
    {
        $this->getPositive()->addQuery($query);
        return $this;
    }

    /**
     * Add a negative query
     * @param Base $query
     * @return $this
     */
    public function addNegative(Base $query)
    {
        $this->getNegative()->addQuery($query);
        return $this;
    }

    /**
     * Set the negative boost
     * @param float $boost
     * @return $this
     */
    public function setNegativeBoost($boost)
    {
        $this->validateFloat($boost, 'negative_boost must be a float');
        $this->addOption('negative_boost', $boost);
        return $this;
    }
}
