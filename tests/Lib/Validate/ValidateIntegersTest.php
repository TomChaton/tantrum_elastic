<?php

namespace tantrum_elastic\tests\Lib\Validate;

use tantrum_elastic\tests;
use tantrum_elastic\Lib\Validate;

class ValidateIntegersTest extends tests\TestCase
{
    use Validate\Integers;

    // validateInteger tests
    
    /**
     * @test
     * @dataProvider validIntegersDataProvider
     */
    public function validateIntegerReturnsTrue($integer)
    {
        self::assertTrue($this->validateInteger($integer));
    }

    /**
     * @test
     * @dataProvider invalidIntegersDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     */
    public function validateIntegerThrowsInvalidIntegerException($integer)
    {
        $this->validateInteger($integer);
    }

    /**
     * @test
     * @dataProvider invalidIntegersDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     * @expectedExceptionMessage This is the exception message you are looking for
     */
    public function validateIntegerThrowsInvalidIntegerExceptionWithCustomMessage($integer)
    {
        $this->validateInteger($integer, 'This is the exception message you are looking for');
    }

    /**
     * @test
     * @dataProvider invalidIntegersDataProvider
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage This is the exception message you are looking for
     */
    public function validateIntegerThrowsCustomExceptionWithCustomMessage($integer)
    {
        $this->validateInteger($integer, 'This is the exception message you are looking for', 'NotSupported');
    }


    // validateIntegerRange tests

    /**
     * @test
     * @dataProvider validIntegerRangeDataProvider
     */
    public function validateIntegerRangeReturnsTrue($integer, $minValue, $maxValue)
    {
        self::assertTrue($this->validateIntegerRange($integer, $minValue, $maxValue));
    }

    /**
     * @test
     * @dataProvider invalidIntegerRangeDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     */
    public function validateIntegerRangeThrowsInvalidIntegerException($integer, $minValue, $maxValue)
    {
        $this->validateIntegerRange($integer, $minValue, $maxValue);
    }

    /**
     * @test
     * @dataProvider invalidIntegerRangeDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     * @expectedExceptionMessage This is the exception message you are looking for
     */
    public function validateIntegerRangeThrowsInvalidIntegerExceptionWithCustomMessage($integer, $minValue, $maxValue)
    {
        $this->validateIntegerRange($integer, $minValue, $maxValue, 'This is the exception message you are looking for');
    }

    /**
     * @test
     * @dataProvider invalidIntegerRangeDataProvider
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage This is the exception message you are looking for
     */
    public function validateIntegerRangeThrowsCustomExceptionWithCustomMessage($integer, $minValue, $maxValue)
    {
        $this->validateIntegerRange($integer, $minValue, $maxValue, 'This is the exception message you are looking for', 'NotSupported');
    }


    // validateMinimumInteger tests
    
    /**
     * @test
     * @dataProvider validIntegerRangeDataProvider
     */
    public function validateMinimumIntegerReturnsTrue($integer, $minValue)
    {
        self::assertTrue($this->validateMinimumInteger($integer, $minValue));
    }

    /**
     * @test
     * @dataProvider invalidMinimumDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     */
    public function validateMinimumIntegerThrowsInvalidIntegerException($integer, $minValue)
    {
        $this->validateMinimumInteger($integer, $minValue);
    }

    /**
     * @test
     * @dataProvider invalidMinimumDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     * @expectedExceptionMessage This is the exception message you are looking for
     */
    public function validateMinimumIntegerThrowsInvalidIntegerExceptionWithCustomMessage($integer, $minValue)
    {
        $this->validateMinimumInteger($integer, $minValue, 'This is the exception message you are looking for');
    }

    /**
     * @test
     * @dataProvider invalidMinimumDataProvider
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage This is the exception message you are looking for
     */
    public function validateMinimumIntegerThrowsCustomExceptionWithCustomMessage($integer, $minValue)
    {
        $this->validateMinimumInteger($integer, $minValue, 'This is the exception message you are looking for', 'NotSupported');
    }


    // validateMaximumInteger tests

    /**
     * @test
     * @dataProvider validIntegerRangeDataProvider
     */
    public function validateMaximumIntegerReturnsTrue($integer, $minValue, $maxValue)
    {
        self::assertTrue($this->validateMaximumInteger($integer, $maxValue));
    }

    /**
     * @test
     * @dataProvider invalidMaximumDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     */
    public function validateMaximumIntegerThrowsInvalidIntegerException($integer, $maxValue)
    {
        $this->validateMaximumInteger($integer, $maxValue);
    }

    /**
     * @test
     * @dataProvider invalidMaximumDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidInteger
     * @expectedExceptionMessage This is the exception message you are looking for
     */
    public function validateMaximumIntegerThrowsInvalidIntegerExceptionwithCustomMessage($integer, $maxValue)
    {
        $this->validateMaximumInteger($integer, $maxValue, 'This is the exception message you are looking for');
    }

    /**
     * @test
     * @dataProvider invalidMaximumDataProvider
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage This is the exception message you are looking for
     */
    public function validateMaximumIntegerThrowsCustomExceptionwithCustomMessage($integer, $maxValue)
    {
        $this->validateMaximumInteger($integer, $maxValue, 'This is the exception message you are looking for', 'NotSupported');
    }


    // Data Providers

    public function validIntegersDataProvider()
    {
        return [
            [0],
            [1],
            [10],
            [2147483647], //max 32 bit integer
            [9223372036854775807], //max 64 bit integer
            [-10],
        ];
    }

    public function validIntegerRangeDataProvider()
    {
        return [
            [25, 25, 25],
            [25, 24, 25],
            [25, 25, 26],
            [-1, -5, 0],
        ];
    }

    public function invalidIntegerRangeDataProvider()
    {
        return [
            [25, 26, 27],
            [25, 23, 24],
            [-1, 0, 10],
            [-10, -100, -50],
        ];
    }

    public function invalidMinimumDataProvider()
    {
        return [
            [22, 25],
            [-1, 0],
            [-101, -100],
        ];
    }

    public function invalidMaximumDataProvider()
    {
        return [
            [25, 24],
            [0, -1],
            [-50, -100],
        ];
    }
}
