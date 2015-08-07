<?php

namespace tantrum_elastic\Transport;

use tantrum_elastic\Lib\Element;
use tantrum_elastic\Request\Base as Request;
use tantrum_elastic\Exception\NotSupported;

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

    /**
     * Exposes the publicly accessible methods on the Request object
     * @param  string $method
     * @param  array  $args
     * @return mixed
     * @throws NotSupported
     */
    public function __call($method, $args = [])
    {
        if (!method_exists($this->element, $method)) {
            throw new NotSupported(sprintf('Unknown container method "%s"', $method));
        }

        return call_user_func_array(
            array($this->element, $method),
            $args
        );
    }

    /**
     * Returns the request object
     * @return Request
     */
    public function getElement()
    {
        return $this->element;
    }
}