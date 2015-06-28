<?php

class FirstTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testTerm()
    {
        $request = new tantrum_elastic\Request();
        $request->setQuery(new tantrum_elastic\Query\Filtered());
        $sort = new tantrum_elastic\Lib\Sort();
        $sort->addTarget('somefield');
        $sort->addValue('asc');
        $request->setSort($sort);
        echo json_encode($request);
    }
}