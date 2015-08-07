<?php

namespace tantrum_elastic\tests\Filter;

use tantrum_elastic\tests;
use tantrum_elastic\Filter;

class TermTest extends tests\TestCase
{
    /**
     * @var tantrum_elastic\Filter\Term
     */
    protected $element;

    /**
     * @test
     */
    public function jsonSerializeSucceeds()
    {
        $field = uniqid();
        $value = uniqid();

        $this->element->setField($field);
        $this->element->setValue($value);

        $expected = sprintf('{"term":{"%s":"%s"}}', $field, $value);
        self::assertEquals($expected, json_encode(self::containerise($this->element)));
    }

    // Utils

    public function setUp()
    {
        $this->element = new Filter\Term();
    }
}
