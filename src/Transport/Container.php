<?php

namespace tantrum_elastic\Transport;

use tantrum_elastic\Lib\Element;
use tantrum_elastic\Request\Base as Request;
use tantrum_elastic\Exception\NotSupported;

/**
 * This is the container for request objects. It gives us a top level object into which all other elements can render
 * themselves
 * @package tantrum_elastic\Transport
 */
class Container extends Element
{
    /**
     * @var Request
     */
    private $element;

    /**
     * Set the request object
     * @param Request $element
     */
    public function __construct(Request $element)
    {
        $this->element = $element;
        $this->addElement($element);
    }
}
