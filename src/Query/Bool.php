<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Exception\IncompatibleValues;
use tantrum_elastic\Lib\Validate;
use tantrum_elastic\Query\Lib\Bool\Must;
use tantrum_elastic\Query\Lib\Bool\MustNot;
use tantrum_elastic\Query\Lib\Bool\Should;
use tantrum_elastic\Query\Lib\Filter;
use tantrum_elastic\Query\Lib\MinimumShouldMatch;
use tantrum_elastic\Query\Lib\Bool\Boost;

/**
 * This class represents the bool query
 * @link: https://www.elastic.co/guide/en/elasticsearch/reference/2.0/query-dsl-bool-query.html
 * @package tantrum_elastic\Query
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
     * @var Filter
     */
    private $filter;

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
     * Return the filter collection. Create one if it doesn't exist
     *
     * @return Filter
     */
    private function getFilter()
    {
        if (is_null($this->filter)) {
            $this->filter = new Filter();
            $this->addElement($this->filter);
        }
        return $this->filter;
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
     * Add a should query.
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

    /**
     * Add a query to the filter element.
     * @param Base $query
     * @return $this
     */
    public function addFilter(Base $query)
    {
        $this->getFilter()->addQuery($query);
        return $this;
    }

    /**
     * @inheritdoc
     * @return bool
     * @throws IncompatibleValues
     */
    protected function validate()
    {
        return $this->validateFilterContext();
    }

    /**
     * Make sure that if we are in filter context with a should clause, that minimum_should_match has been set
     * @return bool
     * @throws IncompatibleValues
     */
    private function validateFilterContext()
    {
        if(is_null($this->filter) === true) {
            return true;
        } elseif(is_null($this->should) === true) {
            return true;
        } else if(array_key_exists('minimum_should_match', $this->options)) {
            return true;
        }

        throw new IncompatibleValues('The bool query in filter context with a should clause must have a minimum_should_match value of at least 1');
    }
}
