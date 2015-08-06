<?php

namespace tantrum_elastic\Query\Lib;

trait MinimumShouldMatch
{
    /**
     * @param integer $minimumShouldMatch
     */
    public function setMinimumMustMatch($minimumShouldMatch)
    {
        $this->validateMinimumInteger($minimumShouldMatch, 1, 'minimum _should_match must be a positive integer');
        $this->addOption('minimum_should_match', $minimumShouldMatch);
        return $this;
    }
}