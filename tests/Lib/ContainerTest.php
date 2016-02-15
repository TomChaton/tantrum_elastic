<?php

namespace tantrum_elastic\tests\Lib;

use tantrum_elastic\tests;
use tantrum_elastic\Lib;

class ContainerTest extends tests\TestCase
{

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\NotFoundException
     * @expectedExceptionMessageRegExp /Cannot make element; No provider for "\w+"/
     */
    public function getThrowsNotFoundException()
    {
        $container = new Lib\Container();
        $container->get(uniqid());
    }

    /**
     * @test
     */
    public function hasReturnsTrue()
    {
        $key = self::uniqid();
        $value = function(){
            return true;
        };

        $container = new Lib\Container();
        $container->addProvider($key, $value);
        self::assertTrue($container->has($key));
    }

    /**
     * @test
     */
    public function hasReturnsFalse()
    {
        $key = self::uniqid();
        $container = new Lib\Container();
        self::assertFalse($container->has($key));
    }
}
