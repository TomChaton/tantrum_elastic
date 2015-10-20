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

    protected $externalOptions = [];

    protected $externalElements = [];

    /**
     * Return the class name of the element converted into snake_case
     *
     * @return string
     */
    public function getElementName()
    {
        $classNameWithNamespace = get_class($this);
        if ($boundary = strrpos($classNameWithNamespace, '\\')) {
            $className = substr($classNameWithNamespace, $boundary+1);
        } else {
            $className = substr($classNameWithNamespace, $boundary);
        }
        preg_match_all('/[A-Z][a-z]+/', $className, $classNameParts);

        return strtolower(implode('_', $classNameParts[0]));
    }

    /**
     * Add an option to this element
     * Options are generally {string} key/ {mixed} value pairs
     * External options are fetched by the containng element and included there
     *
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    final protected function addOption($key, $value, $isInternal = true)
    {
        // @TODO: Check that this value is serializable
        if ($isInternal === true) {
            $this->options[$key] = $value;
        } else {
            $this->externalOptions[$key] = $value;
        }

        return $this;
    }

    /**
     * Add an Element object to this element
     * External elements are fetched by the containng element and included there
     *
     * @param Element $element
     * @param bool    $isInternal
     *
     * @return $this
     */
    final protected function addElement(Element $element, $isInternal = true)
    {
        $elementName = $element->getElementName();

        if ($isInternal === true) {
            $this->elements[$elementName] = $element;
        } else {
            $this->externalElements[$elementName] = $element;
        }

        return $this;
    }

    /**
     * Returns any elements that are to be included in the containing element
     * @return array
     */
    public function getExternalElements()
    {
        return $this->externalElements;
    }

    /**
     * Returns any options that are to be included in the containing element
     * @return array
     */
    public function getExternalOptions()
    {
        return $this->externalOptions;
    }

    /**
     * Returns whether this element contains options
     * @return bool
     */
    public function hasOptions()
    {
        return count($this->options) > 0;
    }

    /**
     * Extract any external elements from the elements and combine them with the elements array
     * @return array
     */
    protected function extractElements()
    {
        $elements = [];
        foreach($this->elements as $element) {
            $elements = array_merge($elements, $element->getExternalElements());
        }
        $elements = array_merge($this->elements, $elements);

        ksort($elements);
        return $elements;
    }

    /**
     * Extract any external options from the elements and combine them with the options array
     * @return array
     */
    protected function extractOptions()
    {
        $options = [];

        // Fetch external options from the elements
        foreach($this->elements as $element) {
            $options = array_merge($options, $element->getExternalOptions());
        }

        //Merge them with our options
        $options = array_merge($this->options, $options);

        // Sort them so the output is consistent
        ksort($options);

        return $options;
    }

    /**
     * Prepare the element for serialization
     *
     * @return mixed
     */
    protected function process()
    {
        $elements = $this->extractElements();
        $options  = $this->extractOptions();

        $serializable = [];

        if(count($elements) > 0) {
            $serializable = $elements;
        }

        if(count($options) > 0) {
            $serializable = array_merge($serializable, $options);
        }

        return $serializable;
    }

    /**
     * Allows descendants to add any elements / options necessary before processing
     */
    protected function preProcess()
    {
    }

    /**
     * Allows descendants to validate their values before processing
     */
    protected function validate()
    {
    }

    /**
     * Return a serializable representation of this object
     * @return mixed
     */
    final public function jsonSerialize()
    {
        $this->validate();
        $this->preProcess();
        return $this->process();
    }
}
