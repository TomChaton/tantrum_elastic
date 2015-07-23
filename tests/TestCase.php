<?php

namespace tantrum_elastic\tests;

use Mockery;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    public function mock($class, $methods = array())
    {
        $methodstring = '';
        if (count($methods) > 0) {
            $methodString = sprintf('[%s]', implode(',', $methods));
        }
        return Mockery::mock($class.$methodstring);
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
}
