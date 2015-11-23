<?php

namespace tantrum_elastic\tests;

use GuzzleHttp\Client;
use Mockery;
use tantrum_elastic\Lib\Element;
use tantrum_elastic\Exception\General;
use Pimple\Container;
use tantrum_elastic\Lib\RequestProvider;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * An array of test fixtures provided by the listener via the setTestFxtures method
     * @var array $testFixtures
     */
    protected $testFixtures;

    /**
     * Set the test fixtures
     * @param $fixtures
     */
    public function setTestFixtures($fixtures)
    {
        $this->testFixtures = $fixtures;
    }

    /**
     * Provides a mocked object
     * @param $class         - The fully qualified namespace of the object to be mocked
     * @param array $methods - Optional: An array of methods to mock (provides a partially mocked object)
     * @return Mockery\MockInterface
     */
    protected function mock($class, $methods = [])
    {
        $methodstring = '';
        if (count($methods) > 0) {
            $methodString = sprintf('[%s]', implode(',', $methods));
        }
        return Mockery::mock($class.$methodstring);
    }

    protected static function containerise(Element $element)
    {
        try {
            return json_encode(new TestContainer($element));
        } catch (\Exception $ex) {
            // This block catches any exceptions thrown in jsonSerialize
            // json_encode wraps any previous exception in an exception and rethrows
            // We need to extract this, because it may be an expectation of a test
            // Mirrors what happens in the Http::encode method
            $previous = $ex->getPrevious();

            if(!is_null($previous) && $previous instanceof General) {
                throw $previous;
            }
            throw $ex;
        }
    }

    /**
     * This method returns a random string for generating field names etc.
     * @return string
     */
    protected static function uniqid()
    {
        return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 13);
    }

    /**
     * Returns a container provisioned with the provided request and logger objects
     * NOTE: This method SHOULD NEVER be used in integration tests
     * @param $request   - Optional: An object which implements or mocks RequestInterface
     * @param $logger    - Optional: An object which implements or mocks AbstractLogger
     * @return Container
     */
    protected function getTestContainer($request = null, $logger = null, $client = null)
    {
        $container = new Container();
        $requestProvider = new RequestProvider($this->initRequest($request));
        $container->register($requestProvider);
        $container['tantrum.logger'] = $this->initLogger($logger);
        $container['client'] = $this->initClient($client);
        return $container;
    }

    /**
     * Initialise a Payload instance
     * @param null $request
     * @return Payload
     */
    private function initRequest($request = null)
    {
        if(is_null($request)) {
            return $this->mock('\GuzzleHttp\Psr7\Request');
        }
        return $request;
    }

    /**
     * Initialise a logger instance
     * @param null $logger
     * @return NullLogger
     */
    private function initLogger($logger = null)
    {
        if(!is_null($logger)) {
            return $logger;
        } else {
            return $this->mock('Psr\Log\NullLogger');
        }
    }

    /**
     * Create a new guzzle client
     * @return Client
     */
    private function initClient($client)
    {
        if(!is_null($client)) {
            return $client;
        } else {
            return $this->mock('guzzleHttp\guzzle\Client');
        }
    }

    public function invalidStringsDataProvider()
    {
        return [
            [1],
            [1.1],
            [[]],
            [new \stdClass()],
            [true],
            [false],
            [null],
        ];
    }

    public function invalidArraysDataProvider()
    {
        return [
            [1],
            [1.1],
            [new \stdClass()],
            [true],
            [false],
            ['string'],
            [null],
        ];
    }

    public function invalidIntegersDataProvider()
    {
        return [
            [1.1],
            [[]],
            [new \stdClass()],
            [true],
            [false],
            [[]],
            [null],
        ];
    }

    public function invalidFloatsDataProvider()
    {
        return [
            [10],
            [[]],
            [new \stdClass()],
            [true],
            [false],
            [[]],
            [null],
        ];
    }

    public function validBooleansDataProvider()
    {
        return [
            [true],
            [false],
        ];
    }
}
