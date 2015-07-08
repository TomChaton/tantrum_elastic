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
    public function setValuesThrowsNotSupportedException()
    {
        $this->element->setValues(array());
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage This element does not accept multiple targets.
     */
    public function setTargetsThrowsNotSupportedException()
    {
        $this->element->setTargets(array());
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidArray
     * @expectedExceptionMessage Array is larger than 0
     */
    public function addTargetThrowsInvalidArrayWithTwoTargets()
    {
        $target1 = uniqid();
        $target2 = uniqid();

        $this->element->addTarget($target1);
        $this->element->addTarget($target2);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidArray
     * @expectedExceptionMessage Array is larger than 0
     */
    public function addValueThrowsInvalidArrayWithTwoValues()
    {
        $value1 = uniqid();
        $value2 = uniqid();

        $this->element->addValue($value1);
        $this->element->addValue($value2);
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
