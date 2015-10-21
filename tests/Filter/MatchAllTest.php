<?php

namespace tantrum_elastic\tests\Filter;

use tantrum_elastic\tests\TestCase;
use tantrum_elastic\Filter\MatchAll;

class MatchAllTest extends TestCase
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
        self::assertEquals(json_encode($this->getExpected()), self::containerise($this->element));
    }

    // Utils

    public function setUp()
    {
        $this->element = new MatchAll();
    }

    protected function getExpected()
    {
        return [
            'match_all' => new \stdClass(),
        ];
    }
}
