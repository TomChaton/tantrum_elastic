<?php

namespace tantrum_elastic\tests\Response;

use tantrum_elastic\tests\TestCase;
use tantrum_elastic\Response;
use tantrum_elastic\Lib;

class SearchTest extends TestCase
{
    use BaseResponseTrait;
    use SearchResponseTrait;

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidResponse
     * @expectedExceptionMessage Invalid response from elasticsearch: Expected key "hits" not found
     */
    public function validateAndSetResponseArrayNoHits()
    {
        $searchResult = $this->emptySearchResult;
        unset($searchResult['hits']);
        $this->request->setResponseArray($searchResult);
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
        $this->request->setResponseArray($searchResult);
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
        $this->request->setResponseArray($searchResult);
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
        $this->request->setResponseArray($searchResult);
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
        $this->request->setResponseArray($searchResult);
        $documentCollection = $this->request->getDocuments();
        self::assertTrue($documentCollection instanceof Lib\DocumentCollection);
        self::assertEquals(1, count($documentCollection));
        self::assertEquals(json_encode($document['_source']), json_encode($documentCollection[0]));
    }

    // Utils

    public function setUp()
    {
        $this->request = new Response\Search();
    }
}
