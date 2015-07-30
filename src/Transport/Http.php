<?php

namespace tantrum_elastic\Transport;

use tantrum_elastic\Request;
use tantrum_elastic\Response;
use tantrum_elastic\Lib\Validate;
use tantrum_elastic\Exception;
use GuzzleHttp;

class Http
{
    use Validate\Strings;
    use Validate\Integers;

    /**
     * Request
     * @var Request\Base
     */
    private $request;

    /**
     * The guzzle HTTP cient
     * @var GuzzleHttp\Client
     */
    private $client;

    /**
     * A requestString object to hold the various url parts 
     * @var RequestString
     */
    private $requestString;

    /**
     * Set the target host name
     * @param string $host
     *
     * @return $this
     */
    public function setHost($host)
    {
        $this->getRequestString()->setHostName($host);
        return $this;
    }

    /**
     * Set the port on which the elasticsearch cluster is running
     *
     * @param integer $port
     *
     * @return $this
     */
    public function setPort($port)
    {
        $this->getRequestString()->setPort($port);
        return $this;
    }

    /**
     * Add an index name/alias to the query string
     *
     * @param string $index
     *
     * @return $this
     */
    public function addIndex($index)
    {
        $this->getRequestString()->addIndex($index);
        return $this;
    }

    /**
     * Add a document type to the query string
     * @param string $documentType
     *
     * @return $this
     */
    public function addDocumentType($documentType)
    {
        $this->getRequestString()->addDocumentType($documentType);
        return $this;
    }

    /**
     * Set the request object that will form the request body
     * @param Request\Base $request
     *
     * @return $this
     */
    public function setRequest(Request\Base $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * Set the http client
     * @param GuzzleHttp\Client $client
     *
     * @return $this
     */
    public function setHttpClient(GuzzleHttp\Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get the http client, or create and return a new one
     *
     * @return GuzzleHttp\Client
     */
    private function getHttpClient()
    {
        if (is_null($this->client)) {
            // @codeCoverageIgnoreStart
            $this->client = new GuzzleHttp\Client();
            // @codeCoverageIgnoreEbd
        }

        return $this->client;
    }

    /**
     * Set the RequestString object
     *
     * @param RequestString $requestString
     *
     * @return $this
     */
    public function setRequestString(RequestString $requestString)
    {
        $this->requestString = $requestString;
        return $this;
    }

    /**
     * Get the RequestString object, or create and return a new one
     *
     * @return RequestString $requestString
     */
    public function getRequestString()
    {
        if (is_null($this->requestString)) {
            $this->requestString = new RequestString();
        }

        return $this->requestString;
    }

    /**
     * Build and send the request
     *
     * @throws Exception\Transport\Client
     * @throws Exception\Transport\Server
     *
     * @return Response\Base
     */
    public function send()
    {
        $client = $this->getHttpClient();
        /** 
            @TODO:
                - Some requests will not have a body
        */
        $this->getRequestString()->setAction($this->request->getAction());
        try {
            $response = $client->request($this->request->getHttpMethod(), $this->getRequestString()->format(), ['body' => json_encode($this->request)]);
        } catch (GuzzleHttp\Exception\ClientException $ex) {
            throw new Exception\Transport\Client($ex->getResponse()->getBody(), $ex->getCode(), $ex);
        } catch (GuzzleHttp\Exception\ServerException $ex) {
            throw new Exception\Transport\Server($ex->getResponse()->getBody(), $ex->getCode(), $ex);
        }

        $responseBuilder = new Response\Builder($this->request, json_decode($response->getBody(), true));
        return $responseBuilder->getResponse();
    }
}
