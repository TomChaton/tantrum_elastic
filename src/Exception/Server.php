<?php

namespace tantrum_elastic\Exception;

class Server extends Request
{
    public function __construct($message, $code, \GuzzleHttp\Exception\ServerException $ex)
    {
        parent::__construct($message, $code, $ex);
    }
}
