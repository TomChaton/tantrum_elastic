<?php

namespace tantrum_elastic\Lib;

abstract class Descriptor extends Element
{
    /**
     * @var $array $targets;
     */
    protected $targets = [];

    /**
     * @var array $data
     */
    protected $data = [];

    /**
     * Add a value to the data array
     * @param $value string
     * @throws Exception\NotSupported
     * @return Descriptor
     */
    abstract function addValue($value);

    /**
     * Set the values array
     * @param $values array
     * @return Descriptor
     */
    abstract function setValues(array $values);

    /**
     * Add a target to the targets array
     * @param  string $target
     * @throws Exception\NotSupported
     * @return Descriptor
     */
    abstract function addTarget($target);

    /**
     * set the targets array
     * @param $targets array
     * @return Descriptor
     */
    abstract function setTargets(array $targets);
} 