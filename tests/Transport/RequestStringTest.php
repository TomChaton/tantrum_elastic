<?php

namespace tantrum_elastic\tests\Transport;

use tantrum_elastic\tests;
use tantrum_elastic\Transport;

class RequestStringTest extends tests\TestCase
{
    
    /**
     * @test
     */
    public function defaultValues()
    {
        self::assertEquals('http://localhost:9200', $this->requestString->format());
    }

    /**
     * @test
     * @dataProvider validHostNamesDataProvider
     */
    public function setHostNameSucceeds($validHostName)
    {
        self::assertNull($this->requestString->setHostName($validHostName));
        self::assertEquals(sprintf('%s:9200', $validHostName), $this->requestString->format());
    }

    /**
     * @test
     * @dataProvider invalidStringsDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidString
     * @expectedExceptionMessage Host name must be a string
     */
    public function setHostNameThrowsInvalidStringException($invalidHostName)
    {
        $this->requestString->setHostName($invalidHostName);
    }

    /**
     * @test
     */
    public function setPortSucceeds()
    {
        $port = rand(1, 65535);
        self::assertNull($this->requestString->setPort($port));
        self::assertEquals(sprintf('http://localhost:%d', $port), $this->requestString->format());
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidPort
     * @expectedExceptionMessage Port is not within valid range 1-65535
     */
    public function setPortTooHigh()
    {
        $port = 65536;
        $this->requestString->setPort($port);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidPort
     * @expectedExceptionMessage Port is not within valid range 1-65535
     */
    public function setPortTooLow()
    {
        $port = 0;
        $this->requestString->setPort($port);
    }

    /**
     * @test
     */
    public function setActionSucceeds()
    {
        $action = uniqid();
        self::assertNull($this->requestString->setAction($action));
        self::assertEquals(sprintf('http://localhost:9200/%s', $action), $this->requestString->format());
    }

    /**
     * @test
     * @dataProvider invalidStringsDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidString
     * @expectedExceptionMessage Action must be a string
     */
    public function setActionThrowsInvalidStringException($invalidAction)
    {
        $this->requestString->setAction($invalidAction);
    }

    /**
     * @test
     */
    public function addDocumentTypeSucceeds()
    {
        $documentType = uniqid();
        self::assertNull($this->requestString->addDocumentType($documentType));
        self::assertEquals(sprintf('http://localhost:9200/%s', $documentType), $this->requestString->format());
    }

    /**
     * @test
     */
    public function addDocumentTypeMultipleSucceeds()
    {
        $documentType1 = uniqid();
        $documentType2 = uniqid();
        self::assertNull($this->requestString->addDocumentType($documentType1));
        self::assertNull($this->requestString->addDocumentType($documentType2));
        self::assertEquals(sprintf('http://localhost:9200/%s,%s', $documentType1, $documentType2), $this->requestString->format());
    }

    /**
     * @test
     * @dataProvider invalidStringsDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidString
     * @expectedExceptionMessage Document type must be a string
     */
    public function addDocumentTypeThrowsInvalidStringException($invalidDocumentType)
    {
        $this->requestString->addDocumentType($invalidDocumentType);
    }

    /**
     * @test
     */
    public function addIndexSucceeds()
    {
        $index = uniqid();
        self::assertNull($this->requestString->addIndex($index));
        self::assertEquals(sprintf('http://localhost:9200/%s', $index), $this->requestString->format());
    }

    /**
     * @test
     */
    public function addIndexMultipleSucceeds()
    {
        $index1 = uniqid();
        $index2 = uniqid();
        self::assertNull($this->requestString->addIndex($index1));
        self::assertNull($this->requestString->addIndex($index2));
        self::assertEquals(sprintf('http://localhost:9200/%s,%s', $index1, $index2), $this->requestString->format());
    }

    /**
     * @test
     * @dataProvider invalidStringsDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidString
     * @expectedExceptionMessage Index must be a string
     */
    public function addIndexThrowsInvalidStringException($invalidIndex)
    {
        $this->requestString->addIndex($invalidIndex);
    }

    /**
     * @test
     */
    public function addQuerySucceeds()
    {
        $key   = uniqid();
        $value = uniqid();
        self::assertNull($this->requestString->addQuery($key, $value));
        self::assertEquals(sprintf('http://localhost:9200/?%s=%s', $key, $value), $this->requestString->format());
    }

    /**
     * @test
     */
    public function addQueryMultipleSucceeds()
    {
        $key1   = uniqid();
        $value1 = uniqid();
        $key2   = uniqid();
        $value2 = uniqid();
        self::assertNull($this->requestString->addQuery($key1, $value1));
        self::assertNull($this->requestString->addQuery($key2, $value2));
        self::assertEquals(sprintf('http://localhost:9200/?%s=%s&%s=%s', $key1, $value1, $key2, $value2), $this->requestString->format());
    }


    // Data Providers
    
    public function validHostNamesDataProvider()
    {
        return [
            ['localhost'],
            ['http://localhost'],
            ['example.com'],
            ['http://example.com'],
            ['http://www.example.com'],
            ['example.co.uk'],
            ['http://example.co.uk'],
            ['http://www.example.co.uk'],
        ];
    }

    // Utils

    public function setUp()
    {
        $this->requestString = new Transport\RequestString();
    }
}
