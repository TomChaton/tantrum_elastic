<?php

namespace tantrum_elastic\tests\Filter;

use tantrum_elastic\tests\Lib;
use tantrum_elastic\Filter;

class TermTest extends Lib\TestCase
{
    /**
     * @var tantrum_elastic\Filter\MatchAll
     */
    protected $element;

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage This element does not accept multiple values.
     */
    public function setValuesThrowsException()
    {
        $this->element->setValues(array());
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage This element does not accept multiple targets.
     */
    public function setTargetsThrowsException()
    {
        $this->element->setTargets(array());
    }

    /**
     * @test
     */
    public function jsonSerializeSucceeds()
    {
        $target = uniqid();
        $value  = uniqid();

        $this->element->addTarget($target);
        $this->element->addValue($value);

        $expected = sprintf('{"term":{"%s":"%s"}}', $target, $value);
        $this->assertEquals($expected, json_encode($this->element));
    }

    // Utils

    public function setUp()
    {
        $this->element = new Filter\Term();
    }
}
