<?php

namespace tantrum_elastic\tests\Query;

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

        $matchAll = new Query\MatchAll();
        self::assertSame($this->query, $this->query->addMust($matchAll));
        self::assertEquals(json_encode($expected), json_encode(self::containerise($this->query)));
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

        $matchAll = new Query\MatchAll();
        self::assertSame($this->query, $this->query->addMust($matchAll));
        self::assertSame($this->query, $this->query->setBoost(1.5));
        self::assertEquals(json_encode($expected), json_encode(self::containerise($this->query)));
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

        $matchAll = new Query\MatchAll();
        self::assertSame($this->query, $this->query->addMustNot($matchAll));
        self::assertEquals(json_encode($expected), json_encode(self::containerise($this->query)));
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

        $matchAll = new Query\MatchAll();
        self::assertSame($this->query, $this->query->AddShould($matchAll));
        self::assertEquals(json_encode($expected), json_encode(self::containerise($this->query)));
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

        $matchAll = new Query\MatchAll();
        self::assertSame($this->query, $this->query->addShould($matchAll));
        self::assertSame($this->query, $this->query->setMinimumShouldMatch(3));
        self::assertEquals(json_encode($expected), json_encode(self::containerise($this->query)));
    }

    public function setUp()
    {
        $this->query = new Query\Bool();
    }
}
