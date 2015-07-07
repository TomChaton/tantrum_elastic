<?php

namespace tantrum_elastic\Lib;

abstract class Descriptor extends Element
{
    /**
     * @var $array $targets;
     */
    protected $targets = [];

    /**
     * @var array $values
     */
    protected $values = [];

    /**
     * Add a value to the values array
     * @param $value string
     * @return Descriptor
     */
    abstract public function addValue($value);

    /**
     * Set the values array
     * @param $values array
     * @throws tantrum_elastic\Exception\NotSupported
     * @return Descriptor
     */
    abstract public function setValues(array $values);

    /**
     * Add a target to the targets array
     * @param  string $target
     * @return Descriptor
     */
    abstract public function addTarget($target);

    /**
     * Set the targets array
     * @param $targets array
     * @throws tantrum_elastic\Exception\NotSupported
     * @return Descriptor
     */
    abstract public function setTargets(array $targets);
}
