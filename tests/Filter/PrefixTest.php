<?php

namespace tantrum_elastic\tests\Filter;

use tantrum_elastic\tests\TestCase;
use tantrum_elastic\Filter\Prefix;

class PrefixTest extends TestCase
{
    /**
     * @var Prefix
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
        self::assertEquals($expected, json_encode(self::containerise($this->element)));
    }

    // Utils

    public function setUp()
    {
        $this->element = new Prefix();
    }
}
