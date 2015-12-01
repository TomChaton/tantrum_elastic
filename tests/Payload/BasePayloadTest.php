<?php

namespace tantrum_elastic\Tests\Payload;

use tantrum_elastic\tests\TestCase;

abstract class PayloadTestBase extends TestCase
{

    /**
     * Returns a stripped down version of the output
     * @return array
     */
    abstract protected function getStandardFormat();

}
