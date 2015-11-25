<?php

namespace tantrum_elastic\tests\Response;

use tantrum_elastic\tests;
use tantrum_elastic\Request;
use tantrum_elastic\Response;

class BuilderTest extends tests\TestCase
{
    use SearchResponseTrait;

    /**
     * @test
     */
    public function buildSearchSucceeds()
    {
        $request = new Request\Search($this->container);
        $builder = new Response\Builder($request, $this->emptySearchResult);
        self::assertTrue($builder->getResponse() instanceof Response\Search);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\NotSupported
     * @expectedExceptionMessageRegExp /Response type "\w+" is not supported/
     */
    public function buildFailsWithInvalidRequestType()
    {
        $request = $this->mock('tantrum_elastic\Request\Search');
        $request->shouldReceive('getType')
            ->once()
            ->andReturn(uniqid());

        $builder = new Response\Builder($request, $this->emptySearchResult);
    }
}
