<?php

namespace tantrum_elastic\tests\Transport;

use GuzzleHttp\Exception\ClientException;

class MockGuzzleClientException extends ClientException
{

    public function __construct($response, $code)
    {
        $this->mockResponse = $response;
        $this->code = $code;
    }

    public function getResponse()
    {
        return $this->mockResponse;
    }
}
