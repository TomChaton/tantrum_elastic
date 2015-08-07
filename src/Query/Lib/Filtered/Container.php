<?php

namespace tantrum_elastic\Query\Lib\Filtered;

use tantrum_elastic\Lib\Container as BaseContainer;

class Container extends BaseContainer
{

    /**
     * Create a match_all option
     */
    public function setMatchAll()
    {
        $this->addOption('match_all', new \stdClass());
    }
}