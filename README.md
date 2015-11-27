# tantrum_elastic

## Build Status
[![Build Status](https://travis-ci.org/tomcroft/tantrum_elastic.svg?branch=dev)](https://travis-ci.org/tomcroft/tantrum_elastic)[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tomcroft/tantrum_elastic/badges/quality-score.png?b=dev)](https://scrutinizer-ci.com/g/tomcroft/tantrum_elastic/?branch=dev)[![Coverage Status](https://coveralls.io/repos/tomcroft/tantrum_elastic/badge.svg?branch=dev&service=github)](https://coveralls.io/github/tomcroft/tantrum_elastic?branch=dev)

## Example Low Level usage
```php
$httpRequest = new \tantrum_elastic\Transport\Http();
$httpRequest->addIndex('movie_db');

$term = new \tantrum_elastic\Filter\Term();
$term->setField('_id');
$term->setValue('4');

$sort = new \tantrum_elastic\Sort\Field();
$sort->setField('title');
$sort->setOrder('asc');

$sortCollection = new \tantrum_elastic\Sort\Collection();
$sortCollection->addSort($sort);

$request = new \tantrum_elastic\Request\Search();
$request->setSort($sortCollection);

$httpRequest->setRequest($request);
$response = $httpRequest->send();

foreach ($response->getDocuments() as $document) {
    print_r($document);
}
```
