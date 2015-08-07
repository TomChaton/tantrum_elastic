<?php

namespace tantrum_elastic\Response;

use tantrum_elastic\Exception;

abstract class Base
{
    const KEY_TOOK      = 'took';
    const KEY_TIMED_OUT = 'timed_out';
    const KEY_SHARDS    = '_shards';

    const SUB_KEY_SHARDS_TOTAL      = 'total';
    const SUB_KEY_SHARDS_SUCCESSFUL = 'successful';
    const SUB_KEY_SHARDS_FAILED     = 'failed';

    /**
     * Expected response keys
     * @var array
     */
    private static $expectedResponseKeys = [
        self::KEY_TOOK,
        self::KEY_TIMED_OUT,
        self::KEY_SHARDS,
    ];

    /**
     * Multi-dimensional array representing the expected sub keys of the response
     * @var array
     */
    private static $expectedResponseSubKeys = [
        self::KEY_SHARDS => [
            self::SUB_KEY_SHARDS_TOTAL,
            self::SUB_KEY_SHARDS_SUCCESSFUL,
            self::SUB_KEY_SHARDS_FAILED,
        ],
    ];

    /**
     * The time taken for the last query
     * @var integer
     */
    private $queryTime;


    /**
     * Method all descendants must implement. Takes the array response from elasticsearch,
     * extracts and validates the data. Called internally from the Base class.
     * @param array $response
     * @return mixed
     */
    abstract protected function validateAndSetResponseArray(array $response);

    /**
     * Validate the response array for common elements
     * Then call the subclass validateAndSetArrayResponse method
     *
     * @param array $response
     *
     * @throws Exception\InvalidResponse
     *
     * @return boolean
     */
    final public function setResponseArray(array $response)
    {
        $this->validateKeys(self::$expectedResponseKeys, $response);
        foreach (self::$expectedResponseSubKeys as $key => $subKeys) {
            $this->validateKeys($subKeys, $response[$key]);
        }

        $this->queryTime = $response[self::KEY_TOOK];

        return $this->validateAndSetResponseArray($response);
    }

    /**
     * Validates an array of keys against the response array
     *
     * @param array $keys
     * @param array $response
     *
     * @throws Exception\Transport\InvalidResponse
     *
     * @return bool
     */
    protected function validateKeys(array $keys, array $response)
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $response)) {
                throw new Exception\Transport\InvalidResponse(sprintf('Invalid response from elasticsearch: Expected key "%s" not found', $key));
            }
        }

        return true;
    }

    /**
     * Get the time taken for the last query
     *
     * @return integer
     */
    public function getQueryTime()
    {
        return $this->queryTime;
    }
}
