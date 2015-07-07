<?php

namespace tantrum_elastic\tests\Filter;

use tantrum_elastic\tests\Lib;

class MatchAll extends Lib\TestCase
{
    /**
     * @var tantrum_elastic\Filter\MatchAll
     */
    protected $element;

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage The match all filter does not accept values.
     */
    public function setValuesThrowsException()
    {
        $this->element->setValues(array());
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage The match all filter does not accept values.
     */
    public function addValueThrowsException()
    {
        $this->element->addValue(\uniqid());
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage The match all filter does not accept targets.
     */
    public function setTargetsThrowsException()
    {
        $this->element->setTargets(array());
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage The match all filter does not accept targets.
     */
    public function addTargetThrowsException()
    {
        $this->element->addTarget(\uniqid());
    }

    /**
     * @test
     */
    public function jsonSerializeSucceeds()
    {
        $expected = '{"match_all":{}}';
        $this->assertEquals($expected, json_encode($this->element));
    }

    // Utils

    public function setUp()
    {
        $this->element = new \tantrum_elastic\Filter\MatchAll();
    }
}
