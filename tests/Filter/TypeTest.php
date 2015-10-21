<?php

namespace tantrum_elastic\tests\Filter;

use tantrum_elastic\tests;
use tantrum_elastic\Filter;

class TypeTest extends tests\TestCase
{
    /**
     * @var tantrum_elastic\Filter\Type
     */
    protected $element;

    /**
     * @test
     */
    public function jsonSerializeSucceeds()
    {
        $value = uniqid();
        $this->element->setValue($value);
        $expected = sprintf('{"type":{"value":"%s"}}', $value);
        self::assertEquals($expected, self::containerise($this->element));
    }

    // Utils
    public function setUp()
    {
        $this->element = new Filter\Type();
    }
}

