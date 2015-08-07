<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Query\Lib\ClauseCollection;
use tantrum_elastic\Lib\Validate;

class Boosting extends Base
{
    use Validate\Floats;

    /**
     * Returns the positive ClauseCollection. Creates one if it doesn't exist
     * @return ClauseCollection
     */
    private function getPositive()
    {
        if (!array_key_exists('positive', $this->elements)) {
            $this->addElement('positive', new ClauseCollection());
        }
        return $this->elements['positive'];
    }

    /**
     * Returns the negative ClauseCollection. Creates one if it doesn't exist
     * @return ClauseCollection
     */
    private function getNegative()
    {
        if (!array_key_exists('negative', $this->elements)) {
            $this->addElement('negative', new ClauseCollection());
        }
        return $this->elements['negative'];
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

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->process('boosting');
    }
}