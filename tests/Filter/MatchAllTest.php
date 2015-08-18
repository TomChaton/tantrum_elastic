<?php

namespace tantrum_elastic\tests\Filter;

use tantrum_elastic\tests;
use tantrum_elastic\Filter\MatchAll;

class MatchAllTest extends tests\TestCase
{
    /**
     * @var MatchAll
     */
    protected $element;

    /**
     * @test
     */
    public function jsonSerializeSucceeds()
    {
        $expected = '{"match_all":{}}';
        self::assertEquals($expected, json_encode($this->element));
    }

    // Utils

    public function setUp()
    {
        $this->element = new MatchAll();
    }
}
