<?php

namespace tantrum_elastic\tests\Lib;

use tantrum_elastic\tests;
use tantrum_elastic\Lib;

class DocumentTest extends tests\TestCase
{
    /**
     * @var tantrum_elastic\Lib\Document
     */
    private $document;

    /**
     * @test
     */
    public function id()
    {
        $id = uniqid();
        $element = $this->element->setId($id);
        self::assertSame($this->element, $element);
        self::assertEquals($id, $element->getId());
    }

    /**
     * @test
     */
    public function index()
    {
        $index = uniqid();
        $element = $this->element->setIndex($index);
        self::assertSame($this->element, $element);
        self::assertEquals($index, $element->getIndex());
    }

    /**
     * @test
     */
    public function score()
    {
        $score = 1.3;

        // Make setScore temorarily accessible
        $scoreMethod = new \ReflectionMethod('tantrum_elastic\Lib\Document', 'setScore');
        $scoreMethod->setAccessible(true);
        $element = $scoreMethod->invokeArgs($this->element, [$score]);

        self::assertSame($this->element, $element);
        self::assertEquals($score, $element->getScore());
    }

    /**
     * @test
     */
    public function sort()
    {
        $sort = [uniqid(), uniqid()];

        // Make setScore temorarily accessible
        $sortMethod = new \ReflectionMethod('tantrum_elastic\Lib\Document', 'setSort');
        $sortMethod->setAccessible(true);
        $element = $sortMethod->invokeArgs($this->element, [$sort]);

        self::assertSame($this->element, $element);
        self::assertEquals($sort, $element->getSort());
    }

    /**
     * @test
     */
    public function type()
    {
        $type = uniqid();
        $element = $this->element->setType($type);
        self::assertSame($this->element, $element);
        self::assertEquals($type, $element->getType());
    }

    /**
     * @test
     */
    public function source()
    {
        $key1 = uniqid();
        $key2 = uniqid();
        $source = [
            'key1' => $key1,
            'key2' => $key2,
        ];
        $element = $this->element->setSource($source);
        self::assertSame($this->element, $element);
        self::assertEquals($key1, $this->element->key1);
        self::assertEquals($key2, $this->element->key2);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidArrayKey
     */
    public function __getThrowsExceptionOnMissingKey()
    {
        $foo = $this->element->bar;
    }

    /**
     * @test
     */
    public function __setSucceeds()
    {
        $this->element->foo = 'bar';
        self::assertEquals('bar', $this->element->foo);
    }

    /**
     * @test
     */
    public function buildFromArray()
    {
        $id     = uniqid();
        $index  = uniqid();
        $score  = '0.12';
        $type   = uniqid();

        $key1 = uniqid();
        $key2 = uniqid();
        $source = [
            'key1' => $key1,
            'key2' => $key2,
        ];

        $sort = [uniqid(), uniqid()];

        $document = [
            '_id'     => $id,
            '_index'  => $index,
            '_score'  => $score,
            '_type'   => $type,
            '_source' => $source,
            'sort'    => $sort,
        ];

        $this->element->buildFromArray($document);
        self::assertEquals($id, $this->element->getId());
        self::assertEquals($index, $this->element->getIndex());
        self::assertEquals($score, $this->element->getScore());
        self::assertEquals($type, $this->element->getType());
        self::assertEquals($sort, $this->element->getSort());
        self::assertEquals($key1, $this->element->key1);
        self::assertEquals($key2, $this->element->key2);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidArrayKey
     */
    public function buildFromArrayThrowsInvalidArrayKey()
    {
        $document = [
            uniqid() => uniqid(),
        ];
        $this->element->buildFromArray($document);
    }

    /**
     * @test
     */
    public function jsonSerialize()
    {
        $id     = uniqid();
        $index  = uniqid();
        $score  = '0.12';
        $type   = uniqid();

        $key1 = uniqid();
        $key2 = uniqid();
        $source = [
            'key1' => $key1,
            'key2' => $key2,
        ];

        $document = [
            '_id'     => $id,
            '_index'  => $index,
            '_score'  => $score,
            '_type'   => $type,
            '_source' => $source,
        ];

        $this->element->buildFromArray($document);

        self::assertEquals(json_encode($source), json_encode($this->element));
    }

    // Utils

    public function setUp()
    {
        $this->element = new Lib\Document();
    }
}
