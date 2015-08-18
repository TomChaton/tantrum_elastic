<?php

namespace tantrum_elastic\tests\Transport;

use tantrum_elastic\tests;
use tantrum_elastic\Transport;
use tantrum_elastic\Request;
use tantrum_elastic\Response;
use GuzzleHttp;

class HttpTest extends tests\TestCase
{
    /**
     * @var tantrum_elastic\Transport\Http $client
     */
    private $client;

    /**
     * @var GuzzleHttp\Client $mockGuzzleClient
     */
    private $mockGuzzleClient;

    /**
     * @var GuzzleHttp\Psr7\Response $mockGuzzleResponse
     */
    private $mockGuzzleResponse;

    /**
     * @var array
     */
    protected $emptySearchRequest = [];

    /**
     * @var array
     */
    protected $emptySearchResponse = [];

    /**
     * @test
     */
    public function setRequestSucceeds()
    {
        $request = new Request\Search();
        self::assertSame($this->client, $this->client->setRequest($request));
    }

    /**
     * @test
     */
    public function setHostSucceeds()
    {
        $host = uniqid();
        $mockRequestString = $this->mock('tantrum_elastic\Transport\RequestString');
        $mockRequestString->shouldReceive('setHostName')
            ->once()
            ->with($host);
        $this->client->setRequestString($mockRequestString);
        self::assertSame($this->client, $this->client->setHost($host));
    }

    /**
     * @test
     */
    public function setPortSucceeds()
    {
        $port = uniqid();
        $mockRequestString = $this->mock('tantrum_elastic\Transport\RequestString');
        $mockRequestString->shouldReceive('setPort')
            ->once()
            ->with($port);
        $this->client->setRequestString($mockRequestString);
        self::assertSame($this->client, $this->client->setPort($port));
    }

    /**
     * @test
     */
    public function addIndexSucceeds()
    {
        $index = uniqid();
        $mockRequestString = $this->mock('tantrum_elastic\Transport\RequestString');
        $mockRequestString->shouldReceive('addIndex')
            ->once()
            ->with($index);
        $this->client->setRequestString($mockRequestString);
        self::assertSame($this->client, $this->client->addIndex($index));
    }

    /**
     * @test
     */
    public function addDocumentTypeSucceeds()
    {
        $documentType = uniqid();
        $mockRequestString = $this->mock('tantrum_elastic\Transport\RequestString');
        $mockRequestString->shouldReceive('addDocumentType')
            ->once()
            ->with($documentType);
        $this->client->setRequestString($mockRequestString);
        self::assertSame($this->client, $this->client->addDocumentType($documentType));
    }

    /**
     * @test
     */
    public function sendSuceeds()
    {
        $request = new Request\Search();
        $this->client->setRequest($request);
        $requestBody = [
            'body' => json_encode($this->emptySearchRequest)
        ];

        $this->mockGuzzleClient
            ->shouldReceive('request')
            ->once()
            ->with('GET', 'http://localhost:9200/_search', $requestBody)
            ->andReturn($this->mockGuzzleResponse);

        $this->mockGuzzleResponse
            ->shouldReceive('getBody')
            ->once()
            ->andReturn(json_encode($this->emptySearchResponse));

        $response = $this->client->send();
        self::assertTrue($response instanceof Response\Search);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\Client
     */
    public function clientExceptionCaught()
    {
        $request = new Request\Search();
        $this->client->setRequest($request);
        $requestBody = [
            'body' => json_encode($this->emptySearchRequest)
        ];

        $mockResponse = $this->mock('stdClass');
        $mockResponse->shouldReceive('getBody')
            ->once();

        $mockException = $this->mock('GuzzleHttp\Exception\ClientException');
        $mockException->shouldReceive('getResponse')
            ->once()
            ->andReturn($mockResponse);
        $mockException->shouldReceive('getCode')
            ->once();

        $this->mockGuzzleClient
            ->shouldReceive('request')
            ->once()
            ->with('GET', 'http://localhost:9200/_search', $requestBody)
            ->andThrow($mockException);

        $response = $this->client->send();
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\Server
     */
    public function serverExceptionCaught()
    {
        $request = new Request\Search();
        $this->client->setRequest($request);
        $requestBody = [
            'body' => json_encode($this->emptySearchRequest)
        ];

        $mockResponse = $this->mock('stdClass');
        $mockResponse->shouldReceive('getBody')
            ->once();

        $mockException = $this->mock('GuzzleHttp\Exception\ServerException');
        $mockException->shouldReceive('getResponse')
            ->once()
            ->andReturn($mockResponse);
        $mockException->shouldReceive('getCode')
            ->once();

        $this->mockGuzzleClient
            ->shouldReceive('request')
            ->once()
            ->with('GET', 'http://localhost:9200/_search', $requestBody)
            ->andThrow($mockException);

        $response = $this->client->send();
    }

    // Utils

    public function setUp()
    {
        $this->client = new Transport\Http();
        $this->mockGuzzleClient = $this->mock('GuzzleHttp\Client');
        $this->client->setHttpClient($this->mockGuzzleClient);

        $this->mockGuzzleResponse = $this->mock('GuzzleHttp\Psr7\Response');

        $this->emptySearchRequest = [
            'query' => [
                'filtered' => [
                    'filter' => ['match_all' => new \stdClass],
                    'query'  => ['match_all' => new \stdClass],
                ],
            ],
            'sort' => [],
        ];

        $this->emptySearchResponse = [
            'took'      => 1,
            'timed_out' => false,
            '_shards'    => [
                'total'      => 5,
                'successful' => 5,
                'failed'     => 0,
            ],
            'hits' => [
                'total'     => 0,
                'max_score' => 0,
                'hits'      => []
            ],
        ];
    }
}
