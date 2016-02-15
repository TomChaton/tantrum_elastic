<?php

namespace tantrum_elastic\tests\Query;

use tantrum_elastic\Exception\IncompatibleValues;
use tantrum_elastic\tests\TestCase;;
use tantrum_elastic\Query;

class BoolTest extends TestCase
{
    /**
     * @var Query\Bool;
     */
    private $query;

    /**
     * @test
     */
    public function mustSucceeds()
    {
        $expected = [
            'bool' => [
                'must' => [
                    ['match_all' => new \stdClass()],
                ],
            ],
        ];

        $matchAll = $this->makeElement('tantrum_elastic\Query\MatchAll');
        self::assertSame($this->query, $this->query->addMust($matchAll));
        self::assertEquals(json_encode($expected), self::containerise($this->query));
    }

    /**
     * @test
     */
    public function mustBoostSucceeds()
    {
        $expected = [
            'bool' => [
                'must' => [
                    ['match_all' => new \stdClass()],
                ],
                'boost' => 1.5,
            ],
        ];

        $matchAll = $this->makeElement('tantrum_elastic\Query\MatchAll');
        self::assertSame($this->query, $this->query->addMust($matchAll));
        self::assertSame($this->query, $this->query->setBoost(1.5));
        self::assertEquals(json_encode($expected), self::containerise($this->query));
    }

    /**
     * @test
     */
    public function mustNotSucceeds()
    {
        $expected = [
            'bool' => [
                'must_not' => [
                    ['match_all' => new \stdClass()],
                ],
            ],
        ];

        $matchAll = $this->makeElement('tantrum_elastic\Query\MatchAll');
        self::assertSame($this->query, $this->query->addMustNot($matchAll));
        self::assertEquals(json_encode($expected), self::containerise($this->query));
    }

    /**
     * @test
     */
    public function ShouldSucceeds()
    {
        $expected = [
            'bool' => [
                'should' => [
                    ['match_all' => new \stdClass()],
                ],
            ],
        ];

        $matchAll = $this->makeElement('tantrum_elastic\Query\MatchAll');
        self::assertSame($this->query, $this->query->AddShould($matchAll));
        self::assertEquals(json_encode($expected), self::containerise($this->query));
    }

    /**
     * @test
     */
    public function shouldMinimumShouldMatchSucceeds()
    {
        $expected = [
            'bool' => [
                'should' => [
                    ['match_all' => new \stdClass()],
                ],
                'minimum_should_match' => 3,
            ],
        ];

        $matchAll = $this->makeElement('tantrum_elastic\Query\MatchAll');
        self::assertSame($this->query, $this->query->addShould($matchAll));
        self::assertSame($this->query, $this->query->setMinimumShouldMatch(3));
        self::assertEquals(json_encode($expected), self::containerise($this->query));
    }

    /**
     * @test
     */
    public function filterSucceeds()
    {
        $expected = [
            'bool' => [
                'filter' => [
                    ['match_all' => new \stdClass()],
                ],
            ],
        ];

        $matchAll = $this->makeElement('tantrum_elastic\Query\MatchAll');
        self::assertSame($this->query, $this->query->addFilter($matchAll));
        self::assertEquals(json_encode($expected), self::containerise($this->query));
    }

    /**
     * @test
     */
    public function filterWithShouldSucceeds()
    {
        $expected = [
            'bool' => [
                'filter' => [
                    ['match_all' => new \stdClass()],
                ],
                'should' => [
                    ['match_all' => new \stdClass()],
                ],
                'minimum_should_match' => 1,
            ],
        ];

        $should = $this->makeElement('tantrum_elastic\Query\MatchAll');
        $filter = $this->makeElement('tantrum_elastic\Query\MatchAll');
        self::assertSame($this->query, $this->query->addFilter($filter));
        self::assertSame($this->query, $this->query->addShould($should));
        self::assertSame($this->query, $this->query->setMinimumShouldMatch(1));
        self::assertEquals(json_encode($expected), self::containerise($this->query));
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\IncompatibleValues
     */
    public function filterContextWithShouldAndNoMinimumShouldMatch()
    {
        $should = $this->makeElement('tantrum_elastic\Query\MatchAll');
        $filter = $this->makeElement('tantrum_elastic\Query\MatchAll');
        self::assertSame($this->query, $this->query->addFilter($filter));
        self::assertSame($this->query, $this->query->addShould($should));
        self::containerise($this->query);
    }

    public function setUp()
    {
        parent::setUp();
        $this->query = $this->makeElement('tantrum_elastic\Query\Bool');
    }
}
