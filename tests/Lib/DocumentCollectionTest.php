<?php

namespace tantrum_elastic\tests\Lib;

use tantrum_elastic\tests;
use tantrum_elastic\Document\Collection;
use tantrum_elastic\Document\Single;

class DocumentCollectionTest extends tests\TestCase
{
    /**
     * @var Collection
     */
    private $element;

    /**
     * @test
     */
    public function buildFromArray()
    {
        $documents = $this->createDocuments();
        $collection = $this->element->buildFromArray($documents);
        self::assertSame($this->element, $collection);
        foreach ($documents as $docKey => $arrayDocument) {
            $document = $this->element[$docKey];
            self::assertTrue($document instanceof Single);
            self::assertEquals($arrayDocument['_id'], $document->getId());
            self::assertEquals($arrayDocument['_score'], $document->getScore());
            self::assertEquals($arrayDocument['_index'], $document->getIndex());
            self::assertEquals($arrayDocument['_type'], $document->getType());
            foreach ($arrayDocument['_source'] as $key => $value) {
                self::assertEquals($value, $document->$key);
            }
        }
    }

    /**
     * @test
     */
    public function addDocument()
    {
        $documents = $this->createDocuments();

        foreach ($documents as $key => $arrayDocument) {
            $document = $this->makeElement('tantrum_elastic\Document\Single');
            $document->buildFromArray($arrayDocument);
            $this->element[$key] = $document;
            self::assertSame($document, $this->element[$key]);
        }
    }

    /**
     * @test
     */
    public function getIterator()
    {
        $documents = $this->createDocuments();
        $collection = $this->element->buildFromArray($documents);
        foreach ($collection as $key => $document) {
            self::assertTrue($document instanceof Single);
        }
    }

    /**searchtest
     * @test
     */
    public function offsetExists()
    {
        $documents = $this->createDocuments();
        $collection = $this->element->buildFromArray($documents);

        self::assertTrue(isset($collection[0]));
        self::assertTrue(isset($collection[1]));
        self::assertFalse(isset($collection[2]));
    }

    /**
     * @test
     */
    public function offsetUnset()
    {
        $documents = $this->createDocuments();
        $collection = $this->element->buildFromArray($documents);

        self::assertTrue(isset($collection[0]));
        self::assertTrue(isset($collection[1]));
        unset($collection[1]);
        self::assertFalse(isset($collection[1]));
    }

    /**
     * @test
     */
    public function countSucceeds()
    {
        $documents = $this->createDocuments();
        $collection = $this->element->buildFromArray($documents);
        self::assertEquals(2, count($collection));
    }

    /**
     * @test
     */
    public function jsonSerialize()
    {
        $documents = $this->createDocuments();
        $collection = $this->element->buildFromArray($documents);
        $expected = json_encode([
            $documents[0]['_source'],
            $documents[1]['_source'],
        ]);
        $this->assertEquals($expected, json_encode($collection));
    }

    // Data providers
    
    public function createDocuments()
    {
        return [
            [
                '_id'     => uniqid(),
                '_score'  => '1.2',
                '_index'  => uniqid(),
                '_type'   => uniqid(),
                '_source' => [
                    'field1' => uniqid(),
                    'field2' => uniqid(),
                ],
            ],
            [
                '_id'     => uniqid(),
                '_score'  => '1.1',
                '_index'  => uniqid(),
                '_type'   => uniqid(),
                '_source' => [
                    'field1' => uniqid(),
                    'field2' => uniqid(),
                ],
            ],
        ];
    }

    // Utilities
    
    public function setUp()
    {
        parent::setUp();
        $this->element = $this->makeElement('tantrum_elastic\Document\Collection');
    }
}
