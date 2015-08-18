<?php

namespace tantrum_elastic\Lib;

use tantrum_elastic\Lib\Validate;
use tantrum_elastic\Exception;

/**
 * Base class from which all query elements must inherit
 */
abstract class Element implements \JsonSerializable
{
    protected $options = [];

    protected $elements = [];

    /**
     * Add an option to this element
     * Options are generally string key/ mixed value pairs
     *
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    final protected function addOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * Add an element to this element
     * Elements are internal to this element when serialized
     *
     * @param mixed $key
     *
     * @param Element $element
     *
     * @return $this
     */
    final protected function addElement($key, Element $element)
    {
        $this->elements[$key] = $element;
        return $this;
    }

    /**
     * Add the options and elements to the serializable representation of this element
     *
     * @param  mixed $serializable
     *
     * @return mixed
     */
    final protected function process($serializable)
    {
        $serializable = $this->processElements($serializable);
        $serializable = $this->processOptions($serializable);
        return $serializable;
    }

    /**
     * Determine the type of serializable we have been passed, and add elements to it accordingly
     *
     * @param  mixed $serializable
     *
     * @throws Exception\NotSupported
     *
     * @return mixed
     */
    private function processElements($serializable)
    {
        if (is_array($serializable)) {
            return $this->processElementsForArray($serializable);
        } elseif (is_object($serializable)) {
            return $this->processElementsForObject($serializable);
        } elseif (is_string($serializable)) {
            return $this->processElementsForString($serializable);
        } else {
            throw new Exception\NotSupported('Cannot process elements for var of type "%s"', gettype($serializable));
        }
    }

    /**
     * Add Elements to an array
     *
     * @param  array  $serializable
     *
     * @return array
     */
    private function processElementsForArray(array $serializable)
    {
        foreach ($this->elements as $key => $element) {
            $serializable[$key] = $element;
        }
        return $serializable;
    }

    /**
     * Add Elements to an Element
     *
     * @param  Element $serializable
     *
     * @return Element
     */
    private function processElementsForObject(Element $serializable)
    {
        foreach ($this->elements as $key => $element) {
            $serializable->addElement($key, $element);
        }
        return $serializable;
    }

    /**
     * Add Elements to a string
     *
     * @param  string $serializable
     *
     * @return mixed
     */
    private function processElementsForString($serializable)
    {
        if (count($this->elements) === 0) {
            return $serializable;
        } else {
            return [
                $serializable => $this->elements,
            ];
        }
    }

    /**
     * Determine the type of serializable we have been passed, and append options to it accordingly
     *
     * @param  mixed $serializable
     *
     * @throws Exception\NotSupported
     *
     * @return mixed
     */
    private function processOptions($serializable)
    {
        if (is_array($serializable)) {
            return $this->processOptionsForArray($serializable);
        } elseif (is_object($serializable)) {
            return $this->processOptionsForObject($serializable);
        } elseif (is_string($serializable)) {
            return $this->processOptionsForString($serializable);
        } else {
            throw new Exception\NotSupported('Cannot process options for var of type "%s"', gettype($serializable));
        }
    }

    /**
     * Append options to an array
     *
     * @param  array  $serializable
     *
     * @return array
     */
    private function processOptionsForArray(array $serializable)
    {
        return array_merge($serializable, $this->options);
    }

    /**
     * Append options to an Element
     *
     * @param  Element $serializable
     *
     * @return Element
     */
    private function processOptionsForObject(Element $serializable)
    {
        foreach ($this->options as $key => $option) {
            $serializable->addOption($key, $option);
        }
        return $serializable;
    }

    /**
     * Add options to a string
     *
     * @param  string $serializable
     *
     * @return mixed
     */
    private function processOptionsForString($serializable)
    {
        if (count($this->options) === 0) {
            return $serializable;
        } else {
            return [
                $serializable => $this->options,
            ];
        }
    }
}
