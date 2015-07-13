# tantrum_elastic

## Todo

### Sort

* Support nested sorting
* Support missing values
* Support unmapped fields
* Support geodistance sorting

## Example usage

$httpRequest = new \tantrum_elastic\Transport\Request();
$httpRequest->setIndex('movie_db');

$term = new \tantrum_elastic\Filter\Term();
$term->addTarget('_id');
$term->addValue('4');

$filter = new \tantrum_elastic\Query\Filtered();
$filter->setFilter($term);

$request = new \tantrum_elastic\Request();
$request->setQuery($filter);
$sortCollection = new \tantrum_elastic\SortCollection();
$sort = new \tantrum_elastic\Sort\Field();
$sort->addTarget('title');
$sort->setOrder('asc');
$sortCollection->addSort($sort);
$request->setSort($sort);

$httpRequest->setRequest($request);
$response = $httpRequest->send();

foreach ($response->getDocuments() as $document) {
    print_r($document);
}