<?php

namespace tantrum_elastic\Exception;

abstract class Request extends General
{
    public function __construct($message, $code, \GuzzleHttp\Exception\BadResponseException $ex)
    {
        $arrayMessage = json_decode($message, true);
        parent::__construct($arrayMessage['error'], $code, $ex);
    }
}
