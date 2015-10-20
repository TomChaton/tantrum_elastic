<?php

namespace tantrum_elastic\Tests\Request;

use tantrum_elastic\Query\Filtered;
use tantrum_elastic\Query\Term;
use tantrum_elastic\tests;
use tantrum_elastic\Request\Search;
use tantrum_elastic\Query;
use tantrum_elastic\Sort;

class SearchTest extends tests\TestCase
{
    /**
     * @var Search
     */
    private $request;

    /**
     * @test
     */
    public function constructorSucceeds()
    {
        $expected = $this->getStandardFormat();
        unset($expected['from']);
        unset($expected['size']);
        self::assertEquals(json_encode($expected), json_encode(self::containerise($this->request)));
    }

    /**
     * @test
     */
    public function setQuerySucceeds()
    {
        $termQueryField = uniqid();
        $termQueryValue = uniqid();

        $filtered = new Filtered();

        $termQuery = new Term();
        $termQuery->setField($termQueryField);
        $termQuery->setValue($termQueryValue);
        $filtered->setQuery($termQuery);

        $this->request->setQuery($filtered);

        $expected = $this->getStandardFormat();
        unset($expected['from']);
        unset($expected['size']);
        $expected['query']['filtered']['query'] = [
            'term' => [$termQueryField => $termQueryValue]
        ];

        self::assertEquals(json_encode($expected), json_encode(self::containerise($this->request)));
    }

    /**
     * @test
     */
    public function setFromSucceeds()
    {
        $from = 10;
        $this->request->setFrom($from);

        $expected = $this->getStandardFormat();
        unset($expected['size']);
        $expected['from'] = $from;

        self::assertEquals(json_encode($expected), json_encode(self::containerise($this->request)));
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     * @expectedExceptionMessage Value for "from" must be greater than or equal to 0 
     */
    public function setFromThrowsInvalidIntegerExceptionWithNegativeValue()
    {
        $this->request->setFrom(-1);
    }

    /**
     * @test
     * @dataProvider invalidIntegersDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     * @expectedExceptionMessage Value for "from" must be an integer 
     */
    public function setFromThrowsInvalidIntegerExceptionWithInvalidInteger($from)
    {
        $this->request->setFrom($from);
    }

    /**
     * @test
     */
    public function setSizeSucceeds()
    {
        $size = 10;
        $this->request->setSize($size);

        $expected = $this->getStandardFormat();
        $expected['size'] = $size;
        unset($expected['from']);

        self::assertEquals(json_encode($expected), json_encode(self::containerise($this->request)));
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     * @expectedExceptionMessage Value for "size" must be greater than or equal to 0 
     */
    public function setSizeThrowsInvalidIntegerExceptionWithNegativeValue()
    {
        $this->request->setSize(-1);
    }

    /**
     * @test
     * @dataProvider invalidIntegersDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     * @expectedExceptionMessage Value for "size" must be an integer 
     */
    public function setSizeThrowsInvalidIntegerExceptionWithInvalidInteger($size)
    {
        $this->request->setSize($size);
    }

    /**
     * @test
     */
    public function setSortSucceeds()
    {
        $sortField  = uniqid();
        $sortField2 = uniqid();

        $sortCollection = new Sort\Collection();

        $sort = new Sort\Field();
        $sort->setField($sortField);
        $sort->setOrder(Sort\Base::ORDER_DESC);
        $sortCollection->addSort($sort);
        $sort = new Sort\Field();
        $sort->setField($sortField2);
        $sort->setOrder(Sort\Base::ORDER_ASC);
        $sortCollection->addSort($sort);

        $this->request->setSort($sortCollection);

        $expected = $this->getStandardFormat();
        unset($expected['from']);
        unset($expected['size']);
        $expected['sort'] = [
            [
                $sortField => ['order' => 'desc'],
            ],
            [
                $sortField2 => ['order' => 'asc'],
            ],
        ];

        self::assertEquals(json_encode($expected), json_encode(self::containerise($this->request)));
    }

    /**
     * @test
     */
    public function getActionSucceeds()
    {
        self::assertEquals('_search', $this->request->getAction());
    }

    /**
     * @test
     */
    public function getTypeSucceeds()
    {
        self::assertEquals('SEARCH', $this->request->getType());
    }

    /**
     * @test
     */
    public function getHttpMethodSucceeds()
    {
        self::assertEquals('GET', $this->request->getHttpMethod());
    }



    // Utils

    public function setUp()
    {
        $this->request = new Search();
    }

    protected function getStandardFormat()
    {
        return [
            'query' => [
                'filtered' => [
                    'filter' => ['match_all' => new \stdClass()],
                    'query'  => ['match_all' => new \stdClass()],
                ],
            ],
            'sort' => [],
            'size' => [],
            'from' => [],
        ];
    }
}
