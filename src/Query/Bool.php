<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Lib\Validate;
use tantrum_elastic\Query\Lib\Bool\ClauseCollection;
use tantrum_elastic\Query\Lib\MinimumShouldMatch;
use tantrum_elastic\Query\Lib\Boost;

/**
 * Class Bool
 * @package tantrum_elastic\Query
 */
class Bool extends Base
{
    use MinimumShouldMatch;
    use Boost;

    use Validate\Integers;
    use Validate\Floats;

    /**
     * Return the must collection. Create one if it doesn't exist
     *
     * @return Collection
     */
    private function getMust()
    {
        if (!array_key_exists('must', $this->elements)) {
            $this->addElement('must', new ClauseCollection());
        }
        return $this->elements['must'];
    }

    /**
     * Return the must_not collection. Create one if it doesn't exist
     *
     * @return Collection
     */
    private function getMustNot()
    {
        if (!array_key_exists('must_not', $this->elements)) {
            $this->addElement('must_not', new ClauseCollection());
        }
        return $this->elements['must_not'];
    }

    /**
     * Return the should collection. Create one if it doesn't exist
     *
     * @return Collection
     */
    private function getShould()
    {
        if (!array_key_exists('should', $this->elements)) {
            $this->addElement('should', new ClauseCollection());
        }
        return $this->elements['should'];
    }


    /**
     * Add a must query
     *
     * @param Base $query
     * @return $this
     */
    public function addMust(Base $query)
    {
        $this->getMust()->addQuery($query);
        return $this;
    }

    /**
     * Add a must_not query
     *
     * @param Base $query
     * @return $this
     */
    public function addMustNot(Base $query)
    {
        $this->getMustNot()->addQuery($query);
        return $this;
    }

    /**
     * Add a should query. Optionally set the minimum_should_match option
     *
     * @param Base $query
     *
     * @return $this
     */
    public function addShould(Base $query)
    {
        $this->getShould()->addQuery($query);
        return $this;
    }

    public function jsonSerialize()
    {
        return $this->process('bool');
    }
}