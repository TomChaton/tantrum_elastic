<?php

namespace tantrum_elastic\Transport;

use tantrum_elastic\Lib;

class Response
{
    const KEY_TOOK      = 'took';
    const KEY_TIMED_OUT = 'timed_out';
    const KEY_SHARDS    = '_shards';
    const KEY_HITS      = 'hits';

    private $expectedKeys = [
        self::KEY_HITS,
        self::KEY_SHARDS,
        self::KEY_TIMED_OUT,
        self::KEY_TOOK,
    ];

    /**
     * Array representation of the json response
     * @var array
     */
    private $arrayResponse = [];

    public function setJsonResponse($jsonResponse)
    {
        $arrayResponse = json_decode($jsonResponse, true);
        
        if (json_last_error() === \JSON_ERROR_NONE) {
            return $this->validateArrayResponse($arrayResponse);
        } else {
            throw new Exception\InvalidResponse(sprintf('Invalid response from elasticsearch: %s', $jsonResponse));
        }
    }

    private function validateArrayResponse($arrayResponse)
    {
        $diff = array_diff($this->expectedKeys, array_keys($arrayResponse));
        if (count($diff) > 0) {
            throw new Exception\InvalidResponse(sprintf('Invalid response from elasticsearch: Unexpected keys; %s', print_r($diff, 1)));
        } elseif (count(array_keys($arrayResponse)) < count($this->expectedKeys)) {
            throw new Exception\InvalidResponse(sprintf('Invalid response from elasticsearch: Expected keys; %s, actual: %s', $this->expectedKeys, array_keys($arrayResponse)));
        }

        $this->arrayResponse = $arrayResponse;

        return true;
    }

    public function getQueryTime()
    {
        return $this->arrayResponse['took'];
    }

    // @todo: create getters for the other response elements

    public function getDocuments()
    {
        $documentCollection = new Lib\DocumentCollection();
        $documentCollection->buildFromArray($this->arrayResponse['hits']);
        return $documentCollection;
    }
}
