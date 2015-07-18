<?php

namespace tantrum_elastic\tests\Validate;

use tantrum_elastic\tests;
use tantrum_elastic\Lib\Validate;

class ValidateStringsTest extends tests\TestCase
{
    use Validate\Strings;

    /**
     * @test
     */
    public function validateStringReturnsTrue()
    {
        self::assertTrue($this->validateString('This is a string'));
    }

    /**
     * @test
     * @dataProvider invalidStringsDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidString
     */
    public function validateStringThrowsInvalidStringException($invalidString)
    {
        $this->validateString($invalidString);
    }

    /**
     * @test
     * @dataProvider invalidStringsDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidString
     * @expectedExceptionMessage This is a custom exception message
     */
    public function validateStringThrowsInvalidStringExceptionWithCustomMessage($invalidString)
    {
        $this->validateString($invalidString, 'This is a custom exception message');
    }

    /**
     * @test
     * @dataProvider invalidStringsDataProvider
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessage This is a custom exception message
     */
    public function validateStringThrowsCustomExceptionWithCustomMessage($invalidString)
    {
        $this->validateString($invalidString, 'This is a custom exception message', 'NotSupported');
    }
}
