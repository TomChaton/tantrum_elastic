<?php

namespace tantrum_elastic\tests;

use Mockery;
use tantrum_elastic\Lib\Build;
use tantrum_elastic\Lib\Element;
use tantrum_elastic\Exception\General;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /** @var Container $container */
    protected $container;

    /**
     * Provides a mocked object
     * @param $namespace         - The class to mock
     * @param array $methods - [Optional] Creates a partial mock with these methods mocked
     * @return Mockery\MockInterface
     */
    protected function mock($namespace, $methods = [])
    {
        $methodstring = '';
        if (count($methods) > 0) {
            $methodString = sprintf('[%s]', implode(',', $methods));
        }

        $object = Mockery::mock($namespace.$methodstring);

        $this->container->addProvider($namespace, function () use ($object){
           return $object;
        });

        return $object;
    }

    protected function makeElement($namespace)
    {
        return $this->container->get($namespace);
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
     * Provision the dependency injection container
     */
    public function setUp()
    {
        parent::setUp();
        $this->container = Build::getContainer();
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
