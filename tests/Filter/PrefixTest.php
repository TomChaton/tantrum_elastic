<?php

namespace tantrum_elastic\tests\Filter;

use tantrum_elastic\tests;
use tantrum_elastic\Filter;

class PrefixTest extends tests\TestCase
{
    /**
     * @var tantrum_elastic\Filter\Prefix
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

        $expected = sprintf('{"prefix":{"%s":"%s"}}', $field, $value);
        self::assertEquals($expected, json_encode($this->element));
    }

    // Utils

    public function setUp()
    {
        $this->element = new Filter\Prefix();
    }
}
