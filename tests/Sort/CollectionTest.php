<?php

namespace tantrum_elastic\tests\Sort;

use tantrum_elastic\tests;
use tantrum_elastic\Sort;

class CollectionTest extends tests\TestCase
{
    /**
     * @var Sort\SortCollection;
     */
    private $element;

    /**
     * @test
     */
    public function emptyCollectionSucceeds()
    {
        $this->assertEquals(json_encode([]), json_encode($this->element));
    }

    /**
     * @test
     */
    public function setSortSucceeds()
    {
        $target = self::uniqid();
        $sort = new Sort\Field();
        $sort->setField($target);
        $this->element->addSort($sort);
        $this->assertEquals(json_encode(['sort' => [$target]]), json_encode(self::containerise($this->element)));
    }

    /**
     * @test
     */
    public function setSortMultipleSucceeds()
    {
        $target1 = self::uniqid();
        $sort = new Sort\Field();
        $sort->setField($target1);
        $this->element->addSort($sort);
        $target2 = self::uniqid();
        $sort = new Sort\Field();
        $sort->setField($target2);
        $this->element->addSort($sort);
        $this->assertEquals(json_encode([$target1, $target2]), json_encode($this->element));
    }


    // Utils

    public function setUp()
    {
        $this->element = new Sort\Collection();
    }
}
