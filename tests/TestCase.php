<?php

namespace tantrum_elastic\tests;

use Mockery;
use tantrum_elastic\Lib\Element;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides a mocked object
     * @param $class         - The class to mock
     * @param array $methods - [Optional] Creates a partial mock with these methods mocked
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
        return new TestContainer($element);
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
}
