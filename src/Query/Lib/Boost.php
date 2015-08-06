<?php

namespace tantrum_elastic\Query\Lib;

trait Boost
{
    /**
     * Set the boost value for this query
     * @param $boost
     * @return $this
     */
    public function setBoost($boost)
    {
        $this->validateFloat($boost);
        $this->addOption('boost', $boost);
        return $this;
    }
}