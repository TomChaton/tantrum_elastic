<?php

namespace tantrum_elastic\Exception\Transport;

use \GuzzleHttp\Exception\ServerException;

class Server extends Request
{
    public function __construct($message, $code, ServerException $ex)
    {
        parent::__construct($message, $code, $ex);
    }
}
