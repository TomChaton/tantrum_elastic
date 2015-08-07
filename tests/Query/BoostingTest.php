<?php

namespace tantrum_elastic\tests\Query;

use tantrum_elastic\Query\Boosting;
use tantrum_elastic\Query\MatchAll;
use tantrum_elastic\tests\TestCase;

class BoostingTest extends TestCase
{
    /**
     * @test
     */
    public function addPositiveSucceeds()
    {
        $matchAll = new MatchAll();

        $expected = [
            'boosting' => [
                'positive' => [
                    ['match_all' => new \stdClass()],
                ],
            ],
        ];
        $query = $this->query->addPositive($matchAll);
        self::assertSame($query, $this->query);
        self::assertEquals(json_encode($expected), json_encode($this->query));
    }

    /**
     * @test
     */
    public function addNegativeSucceeds()
    {
        $matchAll = new MatchAll();

        $expected = [
            'boosting' => [
                'negative' => [
                    ['match_all' => new \stdClass()],
                ],
            ],
        ];
        $query = $this->query->addNegative($matchAll);
        self::assertSame($query, $this->query);
        self::assertEquals(json_encode($expected), json_encode($this->query));
    }

    /**
     * @test
     */
    public function setnegativeBoostSucceeds()
    {
        $matchAll = new MatchAll();

        $expected = [
            'boosting' => [
                'negative' => [
                    ['match_all' => new \stdClass()],
                ],
            ],
            'negative_boost' => 0.3,
        ];

        $query = $this->query->addNegative($matchAll);
        self::assertSame($query, $this->query);
        $query= $this->query->setNegativeBoost(0.3);
        self::assertSame($query, $this->query);
        self::assertEquals(json_encode($expected), json_encode($this->query));
    }

    public function setUp()
    {
        $this->query = new Boosting();
    }
}
