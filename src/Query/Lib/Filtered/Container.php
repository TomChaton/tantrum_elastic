<?php

namespace tantrum_elastic\Query\Lib\Filtered;

use tantrum_elastic\Lib\Container as BaseContainer;

/**
 * @inheritdoc
 * This class is the base class for the filter and query containers in the filtered query
 * It adds the ability to set a default match_all query & filter if none are provided
 * @package tantrum_elastic\Query\Lib\Filtered
 */
abstract class Container extends BaseContainer
{

    /**
     * Create a match_all option
     * Called by the filtered query if there are no filters / queries in the child object
     */
    public function setMatchAll()
    {
        $this->addOption('match_all', new \stdClass());
    }
}
