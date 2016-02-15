<?php

namespace tantrum_elastic\tests\Response;

use tantrum_elastic\tests;
use tantrum_elastic\Response;
use tantrum_elastic\Document\Collection;

class SearchTest extends tests\TestCase
{
    use BaseResponseTrait;
    use SearchResponseTrait;

    /** @var  Response\Search */
    protected $response;

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidResponse
     * @expectedExceptionMessage Invalid response from elasticsearch: Expected key "hits" not found
     */
    public function validateAndSetResponseArrayNoHits()
    {
        $searchResult = $this->emptySearchResult;
        unset($searchResult['hits']);
        $this->response->setResponseArray($searchResult);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidResponse
     * @expectedExceptionMessage Invalid response from elasticsearch: Expected key "hits" not found
     */
    public function validateAndSetResponseArrayNoHitsHits()
    {
        $searchResult = $this->emptySearchResult;
        unset($searchResult['hits']['hits']);
        $this->response->setResponseArray($searchResult);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidResponse
     * @expectedExceptionMessage Invalid response from elasticsearch: Expected key "total" not found
     */
    public function validateAndSetResponseArrayNoHitsTotal()
    {
        $searchResult = $this->emptySearchResult;
        unset($searchResult['hits']['total']);
        $this->response->setResponseArray($searchResult);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidResponse
     * @expectedExceptionMessage Invalid response from elasticsearch: Expected key "max_score" not found
     */
    public function validateAndSetResponseArrayNoHitsMaxScore()
    {
        $searchResult = $this->emptySearchResult;
        unset($searchResult['hits']['max_score']);
        $this->response->setResponseArray($searchResult);
    }

    /**
     * @test
     */
    public function getDocumentsSucceeds()
    {
        $searchResult = $this->emptySearchResult;
        $document = [
            '_source' => [
                uniqid() => uniqid(),
            ],
        ];
        $searchResult['hits']['hits'][] = $document;
        $this->response->setResponseArray($searchResult);
        $documentCollection = $this->response->getDocuments();
        self::assertTrue($documentCollection instanceof Collection);
        self::assertEquals(1, count($documentCollection));
        self::assertEquals(json_encode($document['_source']), json_encode($documentCollection[0]));
    }

    // Utils

    public function setUp()
    {
        parent::setUp();
        $this->response = $this->makeElement('tantrum_elastic\Response\Search');
    }
}
