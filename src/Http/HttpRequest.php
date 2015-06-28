<?php

namespace tantrum_elastic\Http;

use tantrum_elastic\Lib\Validate;

class Request
{
    use Validate\Strings;
    use Validate\Integers;

    private $host = 'http://localhost';

    private $port = '9200';

    private $index = '';

    private $documentType = '';

    public function setHost($host)
    {
        // @Todo: validate a hostname. Regex?
        $this->validateString($host);
        $this->host = $host;
        return $this;
    }

    public function setPort($port)
    {
        // @Todo What should be the minimum?
        $this->validateMinimumInteger($port, 0);
        $this->port = $port;
    }

    public function setIndex($index)
    {
        $this->validateString($index);
        $this->index = $index;
    }

    public function setDocumentType($docmentType)
    {
        $this->validateString($documentType);
        $this->documentType = $documentType;
    }

    public function setRequest(tantrum_elastic\Request $request)
    {
        $this->request = $request;
    }
}
