<?php

namespace tantrum_elastic\tests\Sort;

use tantrum_elastic\tests;
use tantrum_elastic\Sort;

class SortTest extends tests\TestCase
{
    /**
     * @var tantrum_elastic\Sort\Field;
     */
    private $element;

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage Sort objects do not accept values
     */
    public function setValuesThrowsNotSupportedException()
    {
        $this->element->setValues(array());
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage Sort objects do not accept values
     */
    public function addValueThrowsNotSupportedException()
    {
        $this->element->addValue(uniqid());
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidTarget
     * @expectedExceptionMessage A maximum of 1 target is allowed in sort objects
     */
    public function setTargetsThrowsMaximumTargetsExceeded()
    {
        $this->element->setTargets(array(uniqid(), uniqid()));
    }

    /**
     * @test
     */
    public function setTargets()
    {
        $target = uniqid();
        $sort = $this->element->setTargets(array($target));
        self::assertEquals(json_encode($target), json_encode($sort));
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidTarget
     * @expectedExceptionMessage A maximum of 1 target is allowed in sort objects
     */
    public function addTargetThrowsMaximumTargetsExceeded()
    {
        $this->element->addTarget(uniqid());
        $this->element->addTarget(uniqid());
    }

    /**
     * @test
     */
    public function addTarget()
    {
        $target = uniqid();
        $sort = $this->element->addTarget($target);
        self::assertSame($sort, $this->element);
        self::assertEquals(json_encode($target), json_encode($sort));
    }

    /**
     * @test
     * @dataProvider sortOrders
     * @depends addTarget
     */
    public function setOrder($sortOrder)
    {
        $target = uniqid();
        $this->element->addTarget($target);
        $sort = $this->element->setOrder($sortOrder);
        self::assertSame($sort, $this->element);
        $expected = json_encode([$target => ['order' => $sortOrder]]);
        self::assertEquals($expected, json_encode($sort));
    }

    /**
     * @test
     * @dataProvider invalidStringsDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidString
     * @expectedExceptionMessage Order must be a string
     */
    public function setOrderThrowsInvalidStringExceptionWithNonString($sortOrder)
    {
        $this->element->setOrder($sortOrder);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidString
     * @expectedExceptionMessage Order must be one of "asc|desc"
     */
    public function setOrderThrowsInvalidStringExceptionWithInvalidString()
    {
        $this->element->setOrder(uniqid());
    }

    /**
     * @test
     * @dataProvider modes
     * @depends addTarget
     */
    public function setMode($mode)
    {
        $target = uniqid();
        $this->element->addTarget($target);
        $sort = $this->element->setMode($mode);
        self::assertSame($sort, $this->element);
        $expected = json_encode([$target => ['mode' => $mode]]);
        self::assertEquals($expected, json_encode($sort));
    }

    /**
     * @test
     * @dataProvider invalidStringsDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidString
     * @expectedExceptionMessage Mode must be a string
     */
    public function setModeThrowsInvalidStringExceptionWithNonString($mode)
    {
        $this->element->setMode($mode);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidString
     * @expectedExceptionMessage Mode must be one of "avg|max|min|sum"
     */
    public function setModeThrowsInvalidStringExceptionWithInvalidString()
    {
        $this->element->setMode(uniqid());
    }


    // Data providers
    
    public function sortOrders()
    {
        return [
            ['asc'],
            ['desc'],
        ];
    }

    public function modes()
    {
        return [
            ['avg'],
            ['min'],
            ['max'],
            ['sum'],
        ];
    }


    // Utils

    public function setUp()
    {
        $this->element = new Sort\Field();
    }
}
