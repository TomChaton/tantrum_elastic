<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Lib\Validate;
use tantrum_elastic\Query\Lib\Bool\Must;
use tantrum_elastic\Query\Lib\Bool\MustNot;
use tantrum_elastic\Query\Lib\Bool\Should;
use tantrum_elastic\Query\Lib\MinimumShouldMatch;
use tantrum_elastic\Query\Lib\Boost;

/**
 * Class Bool
 * @package tantrum_elastic\Query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-bool-query.html
 */
class Bool extends Base
{
    use MinimumShouldMatch;
    use Boost;

    use Validate\Integers;
    use Validate\Floats;

    /**
     * @var Must
     */
    private $must;

    /**
     * @var MustNot
     */
    private $mustNot;

    /**
     * @var Should
     */
    private $should;

    /**
     * Return the must collection. Create one if it doesn't exist
     *
     * @return Must
     */
    private function getMust()
    {
        if (is_null($this->must)) {
            $this->must = new Must();
            $this->addElement($this->must);
        }
        return $this->must;
    }

    /**
     * Return the must_not collection. Create one if it doesn't exist
     *
     * @return MustNot
     */
    private function getMustNot()
    {
        if (is_null($this->mustNot)) {
            $this->mustNot = new MustNot();
            $this->addElement($this->mustNot);
        }
        return $this->mustNot;
    }

    /**
     * Return the should collection. Create one if it doesn't exist
     *
     * @return Should
     */
    private function getShould()
    {
        if (is_null($this->should)) {
            $this->should = new Should();
            $this->addElement($this->should);
        }
        return $this->should;
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
}