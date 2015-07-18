<?php

namespace tantrum_elastic\tests\Validate;

use tantrum_elastic\tests;
use tantrum_elastic\Lib\Validate;

class ValidateArraysTest extends tests\TestCase
{
    use Validate\Arrays;

    /**
     * @test
     * @dataProvider validArraysDataProvider
     */
    public function validateArrayReturnsTrue($array)
    {
        self::assertTrue($this->validateArray($array));
    }
    /**
     * @test
     * @dataProvider invalidArraysDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidArray
     * @expectedExceptionMessage Value is not an array
     */
    public function validateArrayThrowsInvalidArrayException($invalidArray)
    {
        $this->validateArray($invalidArray);
    }

    /**
     * @test
     * @dataProvider invalidArraysDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidArray
     * @expectedExceptionMessage This is a custom exception message
     */
    public function validateIntegerThrowsInvalidArrayExceptionWithCustomMessage($invalidArray)
    {
        $this->validateArray($invalidArray, 'This is a custom exception message');
    }

    /**
     * @test
     * @dataProvider invalidArraysDataProvider
     * @expectedException tantrum_elastic\Exception\General
     * @expectedExceptionMessage This is a custom exception message
     */
    public function validateIntegerThrowsCustomExceptionWithCustomMessage($invalidArray)
    {
        $this->validateArray($invalidArray, 'This is a custom exception message', 'InvalidArrayKey');
    }

    /**
     * @test
     * @dataProvider validArrayCountDataProvider
     */
    public function validateArrayCountReturnsTrue($array, $min, $max)
    {
        self::assertTrue($this->validateArrayCount($array, $min, $max));
    }

    /**
     * @test
     * @dataProvider invalidArrayCountDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidArray
     */
    public function validateArrayCountThrowsInvalidArrayException($array, $min, $max)
    {
        $this->validateArrayCount($array, $min, $max);
    }

    /**
     * @test
     * @dataProvider invalidArrayCountDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidArray
     * @expectedExceptionMessage This is a custom exception message
     */
    public function validateArrayCountThrowsInvalidArrayExceptionWithCustomMessage($array, $min, $max)
    {
        $this->validateArrayCount($array, $min, $max, 'This is a custom exception message');
    }

    /**
     * @test
     * @dataProvider invalidArrayCountDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidArrayKey
     * @expectedExceptionMessage This is a custom exception message
     */
    public function validateArrayCountThrowsCustomExceptionWithCustomMessage($array, $min, $max)
    {
        $this->validateArrayCount($array, $min, $max, 'This is a custom exception message', 'InvalidArrayKey');
    }

    /**
     * @test
     * @dataProvider validArrayCountDataProvider
     */
    public function validateArrayMinimumCountReturnsTrue($array, $min)
    {
        self::assertTrue($this->validateArrayMinimumCount($array, $min));
    }

    /**
     * @test
     * @dataProvider invalidMinimumArrayCountDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidArray
     * @expectedExceptionMessageRegExp /Array is smaller than \d+/
     */
    public function validateArrayMinimumCountThrowsInvalidArrayException($array, $min)
    {
        $this->validateArrayMinimumCount($array, $min);
    }

    /**
     * @test
     * @dataProvider invalidMinimumArrayCountDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidArray
     * @expectedExceptionMessage This is a custom exception message
     */
    public function validateArrayMinimumCountThrowsInvalidArrayExceptionWithCustomMessage($array, $min)
    {
        $this->validateArrayMinimumCount($array, $min, 'This is a custom exception message');
    }

    /**
     * @test
     * @dataProvider invalidMinimumArrayCountDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidArrayKey
     * @expectedExceptionMessage This is a custom exception message
     */
    public function validateArrayMinimumCountThrowsCustomExceptionWithCustomMessage($array, $min)
    {
        $this->validateArrayMinimumCount($array, $min, 'This is a custom exception message', 'InvalidArrayKey');
    }

    /**
     * @test
     * @dataProvider validArrayCountDataProvider
     */
    public function validateArrayMaximumCountReturnsTrue($array, $min, $max)
    {
        self::assertTrue($this->validateArrayMaximumCount($array, $max));
    }

    /**
     * @test
     * @dataProvider invalidMaximumArrayCountDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidArray
     * @expectedExceptionMessageRegExp /Array is larger than \d+/
     */
    public function validateArrayMaximumCountThrowsInvalidArrayException($array, $max)
    {
        $this->validateArrayMaximumCount($array, $max);
    }

    /**
     * @test
     * @dataProvider invalidMaximumArrayCountDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidArray
     * @expectedExceptionMessage This is a custom exception message
     */
    public function validateArrayMaximumCountThrowsInvalidArrayExceptionWithCustomMessage($array, $max)
    {
        $this->validateArrayMaximumCount($array, $max, 'This is a custom exception message');
    }

    /**
     * @test
     * @dataProvider invalidMaximumArrayCountDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidArrayKey
     * @expectedExceptionMessage This is a custom exception message
     */
    public function validateArrayMaximumCountThrowsCustomExceptionWithCustomMessage($array, $max)
    {
        $this->validateArrayMaximumCount($array, $max, 'This is a custom exception message', 'InvalidArrayKey');
    }

    /**
     * @test
     * @dataProvider valueExistsInArrayDataProvider
     */
    public function validateValueExistsInArrayReturnsTrue($value, $array)
    {
        self::assertTrue($this->validateValueExistsInArray($value, $array));
    }

    /**
     * @test
     * @dataProvider valueNotExistsInArrayDataProvider
     * @expectedException tantrum_elastic\Exception\ArrayValueNotFound
     * @expectedExceptionRegExp /Value \w+ does not exist in array \w+/
     */
    public function validateValueExistsInArrayThrowsArrayValueNotFoundException($value, $array)
    {
        self::assertTrue($this->validateValueExistsInArray($value, $array));
    }

    /**
     * @test
     * @dataProvider valueNotExistsInArrayDataProvider
     * @expectedException tantrum_elastic\Exception\ArrayValueNotFound
     * @expectedException This is a custom exception message
     */
    public function validateValueExistsInArrayThrowsArrayValueNotFoundExceptionWithCustomMessage($value, $array)
    {
        self::assertTrue($this->validateValueExistsInArray($value, $array, 'This is a custom exception message'));
    }

    /**
     * @test
     * @dataProvider valueNotExistsInArrayDataProvider
     * @expectedException tantrum_elastic\Exception\InvalidArgument
     * @expectedException This is a custom exception message
     */
    public function validateValueExistsInArrayThrowsCustomExceptionWithCustomMessage($value, $array)
    {
        self::assertTrue($this->validateValueExistsInArray($value, $array, 'This is a custom exception message', 'InvalidArgument'));
    }


    // Data Providers
    
    public function validArraysDataProvider()
    {
        return [
            [[new \stdClass()]],
            [['one', 'two', 'three']],
            [[1,2,3]],
            [[1, 'two', 3]],
        ];
    }

    public function validArrayCountDataProvider()
    {
        return [
            [
                [new \stdClass()],
                0,
                1,
            ],
            [
                ['one', 'two', 'three'],
                1,
                3,
            ],
            [
                ['one', 'two', 'three'],
                3,
                3,
            ],
        ];
    }

    public function invalidArrayCountDataProvider()
    {
        return [
            [
                [new \stdClass()],
                0,
                0,
            ],
            [
                ['one', 'two', 'three'],
                0,
                2,
            ],
            [
                ['one', 'two', 'three'],
                4,
                10,
            ],
        ];
    }

    public function invalidMinimumArrayCountDataProvider()
    {
        return [
            [
                [new \stdClass()],
                2,
            ],
            [
                ['one', 'two', 'three'],
                4,
            ],
            
        ];
    }

    public function invalidMaximumArrayCountDataProvider()
    {
        return [
            [
                [new \stdClass()],
                0,
            ],
            [
                ['one', 'two', 'three'],
                2,
            ],
            
        ];
    }

    public function valueExistsInArrayDataProvider()
    {
        return [
            [
                'foo',
                ['foo'],
            ],
            [
                'baz',
                ['bar' => 'baz'],
            ],
            [
                'qux',
                [0 => 'qux'],
            ],
            [
                'quux',
                ['foo', 'bar' => 'baz', 'qux' => 'quux'],
            ],
        ];
    }

    public function valueNotExistsInArrayDataProvider()
    {
        return [
            [
                'foo',
                ['food'],
            ],
            [
                'baz',
                ['baz' => 'bar'],
            ],
        ];
    }
}
