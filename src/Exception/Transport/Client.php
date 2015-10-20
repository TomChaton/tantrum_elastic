<?php

namespace tantrum_elastic\Exception\Transport;

use GuzzleHttp\Exception\ClientException;

class Client extends Request
{
    public function __construct($message, $code, ClientException $ex)
    {
        parent::__construct($message, $code, $ex);
    }
}
