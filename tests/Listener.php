<?php

namespace tantrum_elastic\tests;

use tantrum_elastic\tests\IntegrationTests\IntegrationTestCase;

/**
 * Test listener
 * @package tantrum_elastic\tests
 */
class Listener
{
    /** @var  array */
    protected $fixtures = [];

    /**
     * @inheritdoc
     * @param \PHPUnit_Framework_Test $test
     * @param \Exception $e
     * @param float $time
     */
    public function addError(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
    }

    /**
     * @inheritdoc
     * @param \PHPUnit_Framework_Test $test
     * @param \PHPUnit_Framework_AssertionFailedError $e
     * @param float $time
     */
    public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time)
    {
    }

    /**
     * @inheritdoc
     * @param \PHPUnit_Framework_Test $test
     * @param \Exception $e
     * @param float $time
     */
    public function addIncompleteTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
    }

    /**
     * @inheritdoc
     * @param \PHPUnit_Framework_Test $test
     * @param \Exception $e
     * @param float $time
     */
    public function addRiskyTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
    }

    /**
     * @inheritdoc
     * @param \PHPUnit_Framework_Test $test
     * @param \Exception $e
     * @param float $time
     */
    public function addSkippedTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
    }

    /**
     * Set test the fixtures (from startTestSuite()) in the current test
     * @param \PHPUnit_Framework_Test $test
     */
    public function startTest(\PHPUnit_Framework_Test $test)
    {
        if($this->fixtures !== null) {
            $test->setTestFixtures($this->fixtures);
        }
    }

    /**
     * @inheritdoc
     * @param \PHPUnit_Framework_Test $test
     * @param float $time
     */
    public function endTest(\PHPUnit_Framework_Test $test, $time)
    {
    }

    /**
     *
     * @param \PHPUnit_Framework_TestSuite $suite
     */
    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $suiteName = $suite->getName();

        switch($suiteName) {
            case 'Unit':
                echo "\n\nBegin unit tests:\n";
                break;
            case 'Search':
                echo "\n\nBegin integration test \"{$suiteName}\"\n";
                IntegrationTestCase::deleteIndex($suiteName);
                IntegrationTestCase::createIndex($suiteName);
                $this->fixtures = IntegrationTestCase::bulkCreate($suiteName);
                break;
        }
    }

    /**
     * Run post test suite actions.
     * Delete any indexes that were created.
     * @param \PHPUnit_Framework_TestSuite $suite
     */
    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $suiteName = $suite->getName();
        switch($suiteName) {
            case 'Search':
                echo "\n\nIntegration test \"{$suiteName}\" complete\n";
                IntegrationTestCase::deleteIndex($suiteName);
                break;

        }
    }
}
