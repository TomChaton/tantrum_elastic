<?php

namespace tantrum_elastic\tests\Validate;

use tantrum_elastic\tests\TestCase;
use tantrum_elastic\Lib\Validate\Floats;

class ValidateFloatsTest extends TestCase
{
    use Floats;

    /**
     * @test
     * @dataProvider validFloatsDataProvider
     */
    public function validateFloatSucceeds($validFloat)
    {
        self::assertTrue($this->validateFloat($validFloat));
    }

    /**
     * @test
     * @dataProvider invalidFloatsDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidFloat
     */
    public function validateFloatThrowsInvalidFloatException($validFloat)
    {
        self::assertTrue($this->validateFloat($validFloat));
    }

    /**
     * @test
     * @dataProvider invalidFloatsDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidFloat
     * @expectedExceptionMessage This is a custom exception message
     */
    public function validateFloatThrowsInvalidFloatExceptionWithCustomMessage($invalidFloat)
    {
        $this->validateFloat($invalidFloat, 'This is a custom exception message');
    }

    /**
     * @test
     * @dataProvider invalidFloatsDataProvider
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage This is a custom exception message
     */
    public function validateFloatThrowsCustomExceptionWithCustomMessage($invalidFloat)
    {
        $this->validateFloat($invalidFloat, 'This is a custom exception message', 'NotSupported');
    }

    // Data Providers

    public function validFloatsDataProvider()
    {
        return [
            [0.1],
            [-0.1],
            [1.9],
            [1.999],
            [100.0],
        ];
    }
}