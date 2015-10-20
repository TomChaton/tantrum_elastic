<?php

namespace tantrum_elastic\Exception\Transport;

use tantrum_elastic\Exception\General;
use GuzzleHttp\Exception\BadResponseException;

abstract class Request extends General
{
    public function __construct($message, $code, BadResponseException $ex)
    {
        $arrayMessage = json_decode($message, true);
        parent::__construct($arrayMessage['error'], $code, $ex);
    }
}
