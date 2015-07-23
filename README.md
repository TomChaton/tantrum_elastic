# tantrum_elastic

## Build Status
[![Build Status](https://travis-ci.org/tomcroft/tantrum_elastic.svg?branch=dev)](https://travis-ci.org/tomcroft/tantrum_elastic)

## Example Low Level usage

$httpRequest = new \tantrum_elastic\Transport\Http();
$httpRequest->addIndex('movie_db');

$term = new \tantrum_elastic\Filter\Term();
$term->setField('_id');
$term->setValue('4');

$filter = new \tantrum_elastic\Query\Filtered();
$filter->setFilter($term);

$request = new \tantrum_elastic\Request\Search();
$request->setQuery($filter);
$sortCollection = new \tantrum_elastic\Sort\Collection();
$sort = new \tantrum_elastic\Sort\Field();
$sort->setField('title');
$sort->setOrder('asc');
$sortCollection->addSort($sort);
$request->setSort($sortCollection);

$httpRequest->setRequest($request);
$response = $httpRequest->send();

foreach ($response->getDocuments() as $document) {
    print_r($document);
}