<?php

namespace tantrum_elastic\tests\Query;

use tantrum_elastic\tests;
use tantrum_elastic\Query\Filtered;
use tantrum_elastic\Query\Term;
use tantrum_elastic\Filter\Term as TermFilter;

class FilteredTest extends tests\TestCase
{
    /**
     * @var Filtered $element
     */
    private $element;

    /**
     * @test
     */
    public function constructSucceeds()
    {
        $expected = json_encode([
            'filtered' => [
                'filter' => ['match_all' => new \stdClass()],
                'query'  => ['match_all' => new \stdClass()],
            ],
        ]);
        self::assertEquals($expected, json_encode(self::containerise($this->element)));
    }

    /**
     * @test
     */
    public function setQuerySucceeds()
    {
        $field = uniqid();
        $value = uniqid();

        $query = new Term();
        $query->setField($field);
        $query->setValue($value);

        $this->element->setQuery($query);

        $expected = json_encode([
            'filtered' => [
                'filter' => ['match_all' => new \stdClass()],
                'query' => [
                    'term' => [$field => $value],
                ],
            ],
        ]);
        self::assertEquals($expected, json_encode(self::containerise($this->element)));
    }

    /**
     * @test
     */
    public function setFilterSucceeds()
    {
        $field = uniqid();
        $value = uniqid();

        $filter = new TermFilter();
        $filter->setField($field);
        $filter->setValue($value);

        $this->element->setFilter($filter);

        $expected = json_encode([
            'filtered' => [
                'filter' => [
                    'term' => [$field => $value],
                ],
                'query' => ['match_all' => new \stdClass()],
            ],
        ]);
        self::assertEquals($expected, json_encode(self::containerise($this->element)));
    }

    // Utils
    
    public function setUp()
    {
        $this->element = new Filtered();
    }
}
