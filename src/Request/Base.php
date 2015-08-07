<?php

namespace tantrum_elastic\Request;

use tantrum_elastic\Lib;
use tantrum_elastic\Query;
use tantrum_elastic\Sort;

abstract class Base extends Lib\Element
{
    const TYPE_SEARCH = 'SEARCH';

    const ACTION_SEARCH = '_search';

    const HTTP_METHOD_GET = 'GET';

    /**
     * Returns the HTTP method for this request type
     *
     * @return string
     */
    abstract public function getHTTPMethod();

    /**
     * Returns the API action we will be performing
     *
     * @return string
     */
    abstract public function getAction();

    /**
     * Return the type of Request
     *
     * @return string
     */
    abstract public function getType();

    /**
     * Return the lower cased type, as this will be used for serilization
     * @return string
     */
    public function getElementName()
    {
        return strtolower($this->getType());
    }
}
