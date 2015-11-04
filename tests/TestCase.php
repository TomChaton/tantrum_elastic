<?php

namespace tantrum_elastic\tests;

use Mockery;
use tantrum_elastic\Lib\Element;
use tantrum_elastic\Exception\General;

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
