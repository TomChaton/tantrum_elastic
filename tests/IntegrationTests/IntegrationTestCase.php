<?php

namespace tantrum_elastic\tests\IntegrationTests;

use GuzzleHttp;
use tantrum_elastic\Lib\DocumentCollection;
use tantrum_elastic\tests;

/**
 * Base test case for integration tests
 * @package tantrum_elastic\tests\IntegrationTests
 */
abstract class IntegrationTestCase extends tests\TestCase
{
    private static $baseUri = 'http://localhost:9200/';
    private static $indexPattern = 'tantrum_elastic_test_data_%s';

    // Methods available to tests which extend this class

    /**
     * Take an array of document ids in order and create a Collection of Documents from it
     * @param array $ids
     * @return DocumentCollection
     */
    protected function getFixtureCollection(array $ids = [])
    {
        $collection = new DocumentCollection();
        $documents  = [];
        foreach ($ids as $id) {
            $documents[] = $this->testFixtures[$id];
        }
        return $collection->buildFromArray($documents);
    }

    /**
     * Take an array of document ids in order compare it to a Collection of fixture Documents
     * @param array $documentIds
     * @param DocumentCollection $documentCollection
     * @param boolean $scoreNotNull
     * @return void
     */
    protected function assertDocuments(array $documentIds, DocumentCollection $documentCollection, $scoreNotNull)
    {
        $expected = $this->getFixtureCollection($documentIds);
        foreach($documentCollection as $document) {
            // Score is relative to each query, and therefore difficult if not impossible to test
            // Therefore if the test expects a null value we check it is null
            // Otherwise we check that it is a positive float
            // Then we set the score to null to match the fixtures
            if(($scoreNotNull === true && is_float($document->getScore()) && $document->getScore() > 0) ||
                ($scoreNotNull === false && is_null($document->getScore()))) {
                $reflection = new \ReflectionClass('tantrum_elastic\Lib\Document');
                $method = $reflection->getMethod('setScore');
                $method->setAccessible(true);
                $method->invokeArgs($document, [null]);
            }
        }

        self::assertEquals($expected, $documentCollection);
    }


    // Listener methods
    // These are designed to be called from the TestListener

    /*
     * Delete a test index
     * @param string suiteName
     */
    public static function deleteIndex($suiteName)
    {
        echo sprintf("  - Delete index %s\n", self::getIndexName($suiteName));
        try {
            self::getClient()->delete(self::getIndexUrl($suiteName));
        } catch(GuzzleHttp\Exception\ClientException $ex) {
            if($ex->getCode() !== 404) {
                throw $ex;
            }
        }
    }

    /**
     * Create an elasticsearch test index
     * @param string $suiteName
     */
    public static function createIndex($suiteName)
    {
        echo sprintf("  - Create index %s\n", self::getIndexName($suiteName));
        $setup = require(realpath(sprintf(__DIR__.'/Fixtures/%s_setup.php', self::getIndexName($suiteName))));
        self::getClient()->put(self::getIndexUrl($suiteName), ['body' => json_encode(['mappings' => $setup['mappings']])]);
    }

    /**
     * Bulk insert data into a test index
     * @param string $suiteName
     * @return array
     */
    public static function bulkCreate($suiteName)
    {
        echo sprintf("  - Populate index %s\n", self::getIndexName($suiteName));
        $data = file_get_contents(realpath(sprintf(__DIR__.'/Fixtures/%s.txt', self::getIndexName($suiteName))));
        $data = str_replace('{BULK_ACTION_TOKEN}', 'index', $data);
        $fixtures = self::getFixtures($suiteName);

        try {
            self::getclient()->post(self::getIndexUrl($suiteName, '_bulk'), ['body' => $data]);
        } catch(GuzzleHttp\Exception\BadResponseException $ex) {
            var_dump($ex->getResponse()->getBody());
            die(1);
        }

        self::waitForIndex($suiteName, count($fixtures));

        return $fixtures;
    }

    /**
     * Wait for the index to have been populates with the requisite number of documents
     * This could take n m/s on virtual / less pwerful machines
     * @param $suiteName
     * @param $documentCount
     * @return bool
     * @throws \Exception
     */
    public static function waitForIndex($suiteName, $documentCount)
    {
        $documentsIndexed = 0;
        while($documentsIndexed < $documentCount) {
            $response = self::getclient()->get(self::getIndexUrl($suiteName.'/collision/_count'));
            $decodedResponse = json_decode($response->getBody()->getContents(), true);
            $documentsIndexed = $decodedResponse['count'];
        }
        return true;
    }

    /**
     * Load an array of fixtures from an external file
     * @param $suiteName
     * @return mixed
     */
    private static function getFixtures($suiteName)
    {
        $fixtures = require(realpath(sprintf(__DIR__.'/Fixtures/%s.php', self::getIndexName($suiteName))));
        return $fixtures;
    }

    /**
     * Generate an index name from a testSuite name
     * @param $suiteName
     * @return string
     */
    private static function getIndexName($suiteName)
    {
        return sprintf(self::$indexPattern, strtolower($suiteName));
    }

    /**
     * Generate an index url from a testSuite name
     * @param $suiteName
     * @param string $action
     * @return string
     */
    private static function getIndexUrl($suiteName, $action = '')
    {
        return sprintf('%s%s/%s', self::$baseUri, self::getIndexName($suiteName), $action);
    }

    /**
     * Create a new guzzle client
     * @return GuzzleHttp\Client
     */
    private static function getClient()
    {
        return new GuzzleHttp\Client();
    }
}
