<?php

namespace tantrum_elastic\Tests;

class FirstTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testTerm()
    {
        $httpRequest = new \tantrum_elastic\Transport\Request();
        $httpRequest->setIndex('movie_db');

        /*$term = new \tantrum_elastic\Filter\Term();
        $term->addTarget('_id');
        $term->addValue('4');*/

        $filter = new \tantrum_elastic\Query\Filtered();
        //$filter->setFilter($term);

        $request = new \tantrum_elastic\Request();
        $request->setQuery($filter);
        $sort = new \tantrum_elastic\Lib\Sort();
        $sort->addTarget('title');
        $sort->addValue('asc');
        $request->setSort($sort);

        $httpRequest->setRequest($request);
        $response = $httpRequest->send();

        foreach ($response->getDocuments() as $document) {
            echo $document->title."\r\n";
        }
    }
}
