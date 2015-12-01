<?php

namespace tantrum_elastic\Tests\Payload;

use tantrum_elastic\Query\MatchAll;
use tantrum_elastic\Payload\Search;
use tantrum_elastic\Query;
use tantrum_elastic\Sort;

class SearchTest extends PayloadTestBase
{
    use BasePayloadTestTrait;

    /**
     * @var Search
     */
    private $payload;

    /**
     * @test
     */
    public function constructorSucceeds()
    {
        $expected = $this->getStandardFormat();
        unset($expected['from']);
        unset($expected['size']);
        self::assertEquals(json_encode($expected), self::containerise($this->payload));
    }

    /**
     * @test
     */
    public function setQuerySucceeds()
    {
        $this->payload->setQuery(new MatchAll());

        $expected = $this->getStandardFormat();
        unset($expected['from']);
        unset($expected['size']);

        self::assertEquals(json_encode($expected), self::containerise($this->payload));
    }

    /**
     * @test
     */
    public function setFromSucceeds()
    {
        $from = 10;
        $this->payload->setFrom($from);

        $expected = $this->getStandardFormat();
        unset($expected['size']);
        $expected['from'] = $from;

        self::assertEquals(json_encode($expected), self::containerise($this->payload));
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     * @expectedExceptionMessage Value for "from" must be greater than or equal to 0
     */
    public function setFromThrowsInvalidIntegerExceptionWithNegativeValue()
    {
        $this->payload->setFrom(-1);
    }

    /**
     * @test
     * @dataProvider invalidIntegersDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     * @expectedExceptionMessage Value for "from" must be an integer
     */
    public function setFromThrowsInvalidIntegerExceptionWithInvalidInteger($from)
    {
        $this->payload->setFrom($from);
    }

    /**
     * @test
     */
    public function setSizeSucceeds()
    {
        $size = 10;
        $this->payload->setSize($size);

        $expected = $this->getStandardFormat();
        $expected['size'] = $size;
        unset($expected['from']);

        self::assertEquals(json_encode($expected), self::containerise($this->payload));
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     * @expectedExceptionMessage Value for "size" must be greater than or equal to 0
     */
    public function setSizeThrowsInvalidIntegerExceptionWithNegativeValue()
    {
        $this->payload->setSize(-1);
    }

    /**
     * @test
     * @dataProvider invalidIntegersDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     * @expectedExceptionMessage Value for "size" must be an integer
     */
    public function setSizeThrowsInvalidIntegerExceptionWithInvalidInteger($size)
    {
        $this->payload->setSize($size);
    }

    /**
     * @test
     */
    public function setSortSucceeds()
    {
        $sortField  = self::uniqid();
        $sortField2 = self::uniqid();

        $sortCollection = new Sort\Collection();

        $sort = new Sort\Field();
        $sort->setField($sortField);
        $sort->setOrder(Sort\Base::ORDER_DESC);
        $sortCollection->addSort($sort);
        $sort = new Sort\Field();
        $sort->setField($sortField2);
        $sort->setOrder(Sort\Base::ORDER_ASC);
        $sortCollection->addSort($sort);

        $this->payload->setSort($sortCollection);

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

        self::assertEquals(json_encode($expected), self::containerise($this->payload));
    }

    /**
     * @test
     */
    public function getTypeSucceeds()
    {
        self::assertEquals('SEARCH', $this->payload->getType());
    }


    // Utils

    public function setUp()
    {
        $this->payload = new Search();
    }

    final protected function getStandardFormat()
    {
        return [
            'query' => [
                'match_all' => new \stdClass(),
            ],
            'sort' => [],
            'size' => [],
            'from' => [],
        ];
    }
}
