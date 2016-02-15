<?php

namespace tantrum_elastic\tests\Response;

trait BaseResponseTrait
{
    /**
     * @test
     */
    public function validateAndSetResponseArraySuceeds()
    {
        self::assertTrue($this->response->setResponseArray($this->emptySearchResult));
        self::assertEquals($this->emptySearchResult['took'], $this->response->getQueryTime());
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidResponse
     * @expectedExceptionMessage Invalid response from elasticsearch: Expected key "took" not found
     */
    public function validateAndSetResponseArrayNoTook()
    {
        $searchResult = $this->emptySearchResult;
        unset($searchResult['took']);
        $this->response->setResponseArray($searchResult);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidResponse
     * @expectedExceptionMessage Invalid response from elasticsearch: Expected key "timed_out" not found
     */
    public function validateAndSetResponseArrayNoTimedOut()
    {
        $searchResult = $this->emptySearchResult;
        unset($searchResult['timed_out']);
        $this->response->setResponseArray($searchResult);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidResponse
     * @expectedExceptionMessage Invalid response from elasticsearch: Expected key "_shards" not found
     */
    public function validateAndSetResponseArrayNoShards()
    {
        $searchResult = $this->emptySearchResult;
        unset($searchResult['_shards']);
        $this->response->setResponseArray($searchResult);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidResponse
     * @expectedExceptionMessage Invalid response from elasticsearch: Expected key "total" not found
     */
    public function validateAndSetResponseArrayNoShardsTotal()
    {
        $searchResult = $this->emptySearchResult;
        unset($searchResult['_shards']['total']);
        $this->response->setResponseArray($searchResult);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidResponse
     * @expectedExceptionMessage Invalid response from elasticsearch: Expected key "successful" not found
     */
    public function validateAndSetResponseArrayNoShardsSuccessful()
    {
        $searchResult = $this->emptySearchResult;
        unset($searchResult['_shards']['successful']);
        $this->response->setResponseArray($searchResult);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\InvalidResponse
     * @expectedExceptionMessage Invalid response from elasticsearch: Expected key "failed" not found
     */
    public function validateAndSetResponseArrayNoShardsFailed()
    {
        $searchResult = $this->emptySearchResult;
        unset($searchResult['_shards']['failed']);
        $this->response->setResponseArray($searchResult);
    }
}
