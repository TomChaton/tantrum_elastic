<?php

namespace tantrum_elastic\tests\Sort;

use tantrum_elastic\tests;
use tantrum_elastic\Sort;

class FieldTest extends tests\TestCase
{
    /**
     * @var tantrum_elastic\Sort\Field;
     */
    private $element;

    /**
     * @test
     */
    public function setFieldSucceeds()
    {
        $field = uniqid();
        $sort = $this->element->setField($field);
        self::assertSame($sort, $this->element);
        self::assertEquals(json_encode([$field => []]), self::containerise($sort));
    }

    /**
     * @test
     * @dataProvider sortOrders
     * @depends setFieldSucceeds
     */
    public function setOrder($sortOrder)
    {
        $target = uniqid();
        $this->element->setField($target);
        $sort = $this->element->setOrder($sortOrder);
        self::assertSame($sort, $this->element);
        $expected = json_encode([$target => ['order' => $sortOrder]]);
        self::assertEquals($expected, self::containerise($sort));
    }

    /**
     * @test
     * @dataProvider invalidStringsDataProvider
     * @expectedException tantrum_elastic\Exception\Sort\InvalidSortOrder
     * @expectedExceptionMessage Order must be a string
     */
    public function setOrderThrowsInvalidStringExceptionWithNonString($sortOrder)
    {
        $this->element->setOrder($sortOrder);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Sort\InvalidSortOrder
     * @expectedExceptionMessage Order must be one of "asc|desc"
     */
    public function setOrderThrowsInvalidStringExceptionWithInvalidString()
    {
        $this->element->setOrder(uniqid());
    }

    /**
     * @test
     * @dataProvider modes
     * @depends setFieldSucceeds
     */
    public function setMode($mode)
    {
        $target = uniqid();
        $this->element->setField($target);
        $sort = $this->element->setMode($mode);
        self::assertSame($sort, $this->element);
        $expected = json_encode([$target => ['mode' => $mode]]);
        self::assertEquals($expected, self::containerise($sort));
    }

    /**
     * @test
     * @dataProvider invalidStringsDataProvider
     * @expectedException tantrum_elastic\Exception\Sort\InvalidSortMode
     * @expectedExceptionMessage Mode must be a string
     */
    public function setModeThrowsInvalidStringExceptionWithNonString($mode)
    {
        $this->element->setMode($mode);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Sort\InvalidSortMode
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
