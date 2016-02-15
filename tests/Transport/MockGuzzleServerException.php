<?php

namespace tantrum_elastic\tests\Transport;

use GuzzleHttp\Exception\ServerException;

class MockGuzzleServerException extends ServerException
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
