<?php

namespace tantrum_elastic\tests;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{

    public function invalidStringsDataProvider()
    {
        return [
            [1],
            [1.1],
            [[]],
            [new \stdClass()],
            [true],
            [false],
        ];
    }
}
