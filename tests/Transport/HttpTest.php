<?php

namespace tantrum_elastic\tests\Transport;

use tantrum_elastic\tests\TestCase;
use tantrum_elastic\Transport\Http;
use tantrum_elastic\Request;
use tantrum_elastic\Response;
use tantrum_elastic\Sort;
use tantrum_elastic\Query\CommonTerms;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Response as GuzzleResponse;

class HttpTest extends TestCase
{
    /**
     * @var Http $client
     */
    private $client;

    /**
     * @var GuzzleClient $mockGuzzleClient
     */
    private $mockGuzzleClient;

    /**
     * @var GuzzleResponse $mockGuzzleResponse
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
        $request = $this->makeElement('tantrum_elastic\Request\Search');
        self::assertSame($this->client, $this->client->setRequest($request));
    }

    /**
     * @test
     */
    public function setHostSucceeds()
    {
        $host = self::uniqid();
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
        $port = self::uniqid();
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
        $index = self::uniqid();
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
        $documentType = self::uniqid();
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
        $request = $this->makeElement('tantrum_elastic\Request\Search');
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
     * @expectedExceptionMessage MockResponseBody
     * @expectedExceptionCode 123
     */
    public function clientExceptionCaught()
    {
        $request = $this->makeElement('tantrum_elastic\Request\Search');
        $this->client->setRequest($request);
        $requestBody = [
            'body' => json_encode($this->emptySearchRequest)
        ];

        $mockResponse = $this->mock('stdClass');
        $mockResponse->shouldReceive('getBody')
            ->once()
            ->andReturn(json_encode(['error' => 'MockResponseBody']));

        $mockException = new MockGuzzleClientException($mockResponse, 123);

        $this->mockGuzzleClient
            ->shouldReceive('request')
            ->once()
            ->with('GET', 'http://localhost:9200/_search', $requestBody)
            ->andThrow($mockException);

        $this->client->send();
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\Transport\Server
     * @exoectedExceptionMessage MockResponseBody
     * @expectedExceptionCode 123
     */
    public function serverExceptionCaught()
    {
        $request = $this->makeElement('tantrum_elastic\Request\Search');
        $this->client->setRequest($request);
        $requestBody = [
            'body' => json_encode($this->emptySearchRequest)
        ];

        $mockResponse = $this->mock('stdClass');
        $mockResponse->shouldReceive('getBody')
            ->once()
            ->andReturn('MockResponseBody');

        $mockException = new MockGuzzleServerException($mockResponse, 123);

        $this->mockGuzzleClient
            ->shouldReceive('request')
            ->once()
            ->with('GET', 'http://localhost:9200/_search', $requestBody)
            ->andThrow($mockException);

        $client = $this->client->send();
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidString
     */
    public function jsonEncodeExceptionCaughtAndRethrown()
    {
        $request = $this->makeElement('tantrum_elastic\Request\Search');

        $sortCollection = $this->makeElement('tantrum_elastic\Sort\Collection');
        $sort = $this->makeElement('tantrum_elastic\Sort\Field');
        $sort->setField('thisField');
        $sortCollection->addSort($sort);
        $request->setSort($sortCollection);
        // Add an empty common terms query. The empty query string value will throw an exception
        $request->setQuery($this->makeElement('tantrum_elastic\Query\CommonTerms'));
        $this->client->setRequest($request);
        $this->client->send();
    }

    // Utils

    public function setUp()
    {
        parent::setUp();
        $this->client = $this->makeElement('tantrum_elastic\Transport\Http');
        $this->mockGuzzleClient = $this->mock('GuzzleHttp\Client');

        $this->mockGuzzleResponse = $this->mock('GuzzleHttp\Psr7\Response');

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
}
