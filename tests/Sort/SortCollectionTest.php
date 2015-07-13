<?php

namespace tantrum_elastic\tests\Sort;

use tantrum_elastic\tests;
use tantrum_elastic\Sort;

class SortCollectionTest extends tests\TestCase
{
    /**
     * @var tantrum_elastic\Sort\SortCollection;
     */
    private $element;

    /**
     * @test
     */
    public function emptyCollectionSucceeds()
    {
        $this->assertEquals(json_encode(['sort' => []]), json_encode($this->element));
    }

    /**
     * @test
     */
    public function setSortSucceeds()
    {
        $target = uniqid();
        $sort = new Sort\Field();
        $sort->addTarget($target);
        $this->element->addSort($sort);
        $this->assertEquals(json_encode(['sort' => [$target]]), json_encode($this->element));
    }

    /**
     * @test
     */
    public function setSortMultipleSucceeds()
    {
        $target1 = uniqid();
        $sort = new Sort\Field();
        $sort->addTarget($target1);
        $this->element->addSort($sort);
        $target2 = uniqid();
        $sort = new Sort\Field();
        $sort->addTarget($target2);
        $this->element->addSort($sort);
        $this->assertEquals(json_encode(['sort' => [$target1, $target2]]), json_encode($this->element));
    }


    // Utils

    public function setUp()
    {
        $this->element = new Sort\SortCollection();
    }
}
