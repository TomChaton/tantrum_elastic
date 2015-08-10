<?php

namespace tantrum_elastic\tests;

use tantrum_elastic\Exception;
use tantrum_elastic\tests\TestCase;
use tantrum_elastic\Query\MultiMatch;

class MultiMatchTest extends TestCase
{
    /**
     * @var MultiMatch
     */
    private $query;

    /**
     * @test
     */
    public function MultiMatchSucceeds()
    {
        $field = uniqid();
        $value = uniqid();

        $expected = [
            'multi_match' => [
                'query'  => $value,
                'fields' => [$field],
            ],
        ];

        $query = $this->query->addField($field);
        self::assertSame($query, $this->query);
        $query =$this->query->setValue($value);
        self::assertSame($query, $this->query);

        self::assertEquals(json_encode($expected), json_encode($this->query));
    }

    /**
     * @test
     */
    public function MultiMatchSucceedsMultipleFields()
    {
        $field1 = uniqid();
        $field2 = uniqid();
        $value  = uniqid();

        $expected = [
            'multi_match' => [
                'query'  => $value,
                'fields' => [$field1, $field2],
            ],
        ];

        $query = $this->query->addField($field1);
        self::assertSame($query, $this->query);
        $query = $this->query->addField($field2);
        self::assertSame($query, $this->query);
        $query = $this->query->setValue($value);
        self::assertSame($query, $this->query);

        self::assertEquals(json_encode($expected), json_encode($this->query));
    }

    /**
     * @test
     * @dataProvider multimatchTypesDataProvider
     */
    public function MultiMatchWithTypeSucceeds($type)
    {
        $field = uniqid();
        $value = uniqid();

        $expected = [
            'multi_match' => [
                'type'   => $type,
                'query'  => $value,
                'fields' => [$field],
            ],
        ];

        $query =$this->query->addField($field);
        self::assertSame($query, $this->query);
        $query = $this->query->setValue($value);
        self::assertSame($query, $this->query);
        $query = $this->query->setType($type);
        self::assertSame($query, $this->query);

        self::assertEquals(json_encode($expected), json_encode($this->query));
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\NotSupported
     */
    public function MultiMatchWithTypeThrowsNotSupportedException()
    {
        $this->query->setType(uniqid());
    }

    /**
     * @test
     */
    public function MultiMatchWithTieBreakerSucceeds()
    {
        $field = uniqid();
        $value = uniqid();

        $expected = [
            'multi_match' => [
                'tie_breaker' => 0.3,
                'query'       => $value,
                'fields'      => [$field],
            ],
        ];

        $query = $this->query->addField($field);
        self::assertSame($query, $this->query);
        $query = $this->query->setValue($value);
        self::assertSame($query, $this->query);
        $query = $this->query->setTieBreaker(0.3);
        self::assertSame($query, $this->query);
        self::assertEquals(json_encode($expected), json_encode($this->query));
    }

    /**
     * @test
     * @dataProvider invalidFloatsDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidFloat
     */
    public function MultiMatchWithTieBreakerThrowsInvalidFloatException($tieBreaker)
    {
        $this->query->setTieBreaker($tieBreaker);
    }

    /**
     * @test
     * @dataProvider multimatchOperatorsDataProvider
     */
    public function MultiMatchWithOperatorSucceeds($operator)
    {
        $field = uniqid();
        $value = uniqid();

        $expected = [
            'multi_match' => [
                'operator' => $operator,
                'query'    => $value,
                'fields'   => [$field],
            ],
        ];

        $query = $this->query->addField($field);
        self::assertSame($query, $this->query);
        $query = $this->query->setValue($value);
        self::assertSame($query, $this->query);
        $query = $this->query->setOperator($operator);
        self::assertSame($query, $this->query);

        self::assertEquals(json_encode($expected), json_encode($this->query));
    }

    /**
     * @test
     */
    public function MultiMatchWithMinimumShouldMatchSucceeds()
    {
        $field = uniqid();
        $value = uniqid();

        $expected = [
            'multi_match' => [
                'minimum_should_match' => 3,
                'query'                => $value,
                'fields'               => [$field],
            ],
        ];

        $query = $this->query->addField($field);
        self::assertSame($query, $this->query);
        $query = $this->query->setValue($value);
        self::assertSame($query, $this->query);
        $query = $this->query->setMinimumShouldMatch(3);
        self::assertSame($query, $this->query);

        self::assertEquals(json_encode($expected), json_encode($this->query));
    }

    // Data Providers

    public function multimatchTypesDataProvider()
    {
        $types = [];
        foreach(MultiMatch::$allowedTypes as $type) {
            $types[] = [$type];
        }
        return $types;
    }

    public function multimatchOperatorsDataProvider()
    {
        $operators = [];
        foreach(MultiMatch::$allowedOperators as $operator) {
            $operators[] = [$operator];
        }
        return $operators;
    }

    // Utils

    public function setUp()
    {
        $this->query = new MultiMatch();
    }
}