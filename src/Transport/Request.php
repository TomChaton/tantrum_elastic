<?php

namespace tantrum_elastic\Transport;

use tantrum_elastic\Lib\Validate;
use GuzzleHttp;

class Request
{
    use Validate\Strings;
    use Validate\Integers;

    /**
     * Elasticsearch node hostname
     * @var string
     */
    protected $host = 'http://localhost';

    /**
     * Elasticsearch node port
     * @var integer
     */
    protected $port = 9200;

    /**
     * Index name
     * @var string
     */
    protected $index = '';

    /**
     * Document type
     * @var string
     */
    protected $documentType = '';

    /**
     * Request
     * @var tantrum_elastic\Request
     */
    protected $request;

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

    public function setRequest(\tantrum_elastic\Request $request)
    {
        $this->request = $request;
    }

    public function send()
    {
        // @todo: Support other restful verbs and es request types!
        $client = new GuzzleHttp\Client();
        $jsonResponse = $client->post(sprintf('%s:%s/%s/_search', $this->host, $this->port, $this->index), ['body' => json_encode($this->request)]);

        $response = new Response();
        $response->setJsonResponse($jsonResponse->getBody()->getContents());
        return $response;
    }
}
