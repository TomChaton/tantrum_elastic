<?php

namespace tantrum_elastic\tests\Transport;

use tantrum_elastic\tests;
use tantrum_elastic\Transport;
use tantrum_elastic\Payload;
use tantrum_elastic\Response;
use tantrum_elastic\Sort;
use tantrum_elastic\Query\CommonTerms;
use GuzzleHttp;

class HttpTest extends tests\TestCase
{
    /**
     * @var tantrum_elastic\Transport\Http $client
     */
    private $client;

    /**
     * @var GuzzleHttp\Psr7\Request $mockGuzzleRequest
     */
    private $mockGuzzleRequest;

    /**
     * @var GuzzleHttp\Psr7\Response $mockGuzzleResponse
     */
    private $mockGuzzleResponse;

    /**
     * @var GuzzleHttp\Guzzle\Client $mockGuzzleClient
     */
    private $mockGuzzleClient;

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
    public function sendSuceeds()
    {
        $request = new Payload\Search();
        $client = $this->getHttp()->setRequest($request);

        $this->mockGuzzleResponse
            ->shouldReceive('getBody')
            ->once()
            ->andReturn(json_encode($this->emptySearchResponse));

        $this->mockGuzzleRequest
            ->shouldReceive('withBody')
            ->once()
            ->with($request)
            ->andReturn($this->mockGuzzleRequest);

        $this->mockGuzzleClient
            ->shouldReceive('send')
            ->once()
            ->with($this->mockGuzzleRequest)
            ->andReturn($this->mockGuzzleResponse);

        $response = $client->send();
        self::assertTrue($response instanceof Response\Search);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\Client
     */
    public function clientExceptionCaught()
    {
        $request = new Payload\Search();
        $client = $this->getHttp()->setRequest($request);

        $mockResponse = $this->mock('stdClass');
        $mockResponse->shouldReceive('getBody')
            ->once();

        $mockException = $this->mock('GuzzleHttp\Exception\ClientException');
        $mockException->shouldReceive('getResponse')
            ->once()
            ->andReturn($mockResponse);
        $mockException->shouldReceive('getCode')
            ->once();

        $this->mockGuzzleRequest
            ->shouldReceive('withBody')
            ->once()
            ->with($request)
            ->andThrow($mockException);

        $client->send();
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\Server
     */
    public function serverExceptionCaught()
    {
        $request = new Payload\Search();
        $client = $this->getHttp()->setRequest($request);

        $mockResponse = $this->mock('stdClass');
        $mockResponse->shouldReceive('getBody')
            ->once();

        $mockException = $this->mock('GuzzleHttp\Exception\ServerException');
        $mockException->shouldReceive('getResponse')
            ->once()
            ->andReturn($mockResponse);
        $mockException->shouldReceive('getCode')
            ->once();

        $this->mockGuzzleRequest
            ->shouldReceive('withBody')
            ->once()
            ->with($request)
            ->andReturn($this->mockGuzzleRequest);

        $this->mockGuzzleClient
            ->shouldReceive('send')
            ->once()
            ->andThrow($mockException);

        $client->send();
    }
    
    // Utils

    public function setUp()
    {
        $this->mockGuzzleRequest  = $this->mock('GuzzleHttp\Psr7\Request');
        $this->mockGuzzleResponse = $this->mock('GuzzleHttp\Psr7\Response');
        $this->mockGuzzleClient   = $this->mock('GuzzleHttp\guzzle\Client');

        $this->emptySearchRequest = [
            'query' => [
                'match_all' => new \stdClass,
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

    /**
     * Provision an http object with a test container
     * @return Transport\Http
     */
    protected function getHttp()
    {
        $container = $this->getTestContainer($this->mockGuzzleRequest, $this->mockGuzzleResponse, $this->mockGuzzleClient);
        return new Transport\Http($container);
    }
}
