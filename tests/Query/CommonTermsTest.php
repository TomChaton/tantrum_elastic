<?php

namespace tantrum_elastic\Tests\Query;

use tantrum_elastic\Exception\IncompatibleValues;
use tantrum_elastic\Exception\InvalidString;
use tantrum_elastic\Query\CommonTerms;
use tantrum_elastic\tests\TestCase;

class CommonTermsTest extends TestCase
{
    /**
     * @var CommonTerms;
     */
    private $query;

    /**
     * @var array
     */
    private $baseExpectation = [];

    /**
     * @test
     */
    public function setQuerySucceeds()
    {
        $query = 'This is some query text';
        $this->query->setQuery($query);

        $expectation = $this->baseExpectation;
        $expectation['common']['body']['query'] = $query;
        unset($expectation['common']['body']['cutoff_frequency']);
        unset($expectation['common']['body']['low_freq_operator']);
        unset($expectation['common']['body']['minimum_should_match']);

        self::assertEquals(json_encode($expectation), self::containerise($this->query));
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidString
     * @expectedExceptionMessage common -> body -> query cannot be zero length
     */
    public function setQueryThrowsInvalidStringException()
    {
        $query = '';
        $this->query->setQuery($query);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\InvalidString
     * @expectedExceptionMessage common -> body -> query cannot be empty
     */
    public function emptyQueryThrowsInvalidStringException()
    {
        self::containerise($this->query);
    }

    /**
     * @test
     */
    public function setCutoffFrequencySucceeds()
    {
        $query = 'This is some query text';
        $this->query->setQuery($query);

        $cutoffFrequency = 0.001;
        $this->query->setCutoffFrequency($cutoffFrequency);

        $expectation = $this->baseExpectation;
        $expectation['common']['body']['query'] = $query;
        $expectation['common']['body']['cutoff_frequency'] = $cutoffFrequency;
        unset($expectation['common']['body']['low_freq_operator']);
        unset($expectation['common']['body']['minimum_should_match']);

        self::assertEquals(json_encode($expectation), self::containerise($this->query));
    }

    /**
     * @test
     */
    public function setHighFreqSucceeds()
    {
        $query = 'This is some query text';
        $frequency = rand(1, 100);
        $this->query->setHighFreq($frequency);
        $this->query->setQuery($query);

        $expectation = $this->baseExpectation;
        $expectation['common']['body']['query'] = $query;
        unset($expectation['common']['body']['cutoff_frequency']);
        unset($expectation['common']['body']['low_freq_operator']);
        $expectation['common']['body']['minimum_should_match']['high_freq'] = $frequency;
        unset($expectation['common']['body']['minimum_should_match']['low_freq']);

        self::assertEquals(json_encode($expectation), self::containerise($this->query));
    }

    /**
     * @test
     */
    public function setLowFreqSucceeds()
    {
        $query = 'This is some query text';
        $frequency = rand(1, 100);
        $this->query->setLowFreq($frequency);
        $this->query->setQuery($query);

        $expectation = $this->baseExpectation;
        $expectation['common']['body']['query'] = $query;
        unset($expectation['common']['body']['cutoff_frequency']);
        unset($expectation['common']['body']['low_freq_operator']);
        unset($expectation['common']['body']['minimum_should_match']['high_freq']);
        $expectation['common']['body']['minimum_should_match']['low_freq'] = $frequency;

        self::assertEquals(json_encode($expectation), self::containerise($this->query));
    }

    /**
     * @test
     * @dataProvider lowFreqOperatorsDataProvider
     */
    public function setLowFreqOperatorSucceeds($lowFreqOperator)
    {
        $query = 'This is some query text';
        $this->query->setQuery($query);

        $this->query->setLowFreqOperator($lowFreqOperator);

        $expectation = $this->baseExpectation;
        $expectation['common']['body']['query'] = $query;
        unset($expectation['common']['body']['cutoff_frequency']);;
        $expectation['common']['body']['low_freq_operator'] = $lowFreqOperator;
        unset($expectation['common']['body']['minimum_should_match']);

        self::assertEquals(json_encode($expectation), self::containerise($this->query));
    }

    /**
     * @test
     */
    public function setMinimumShouldMatchSucceeds()
    {
        $query = 'This is some query text';
        $this->query->setQuery($query);

        $minimumShouldMatch = 2;
        $this->query->setMinimumShouldMatch($minimumShouldMatch);

        $expectation = $this->baseExpectation;
        $expectation['common']['body']['query'] = $query;
        unset($expectation['common']['body']['cutoff_frequency']);;
        unset($expectation['common']['body']['low_freq_operator']);
        $expectation['common']['body']['minimum_should_match'] = $minimumShouldMatch;

        self::assertEquals(json_encode($expectation), self::containerise($this->query));
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\IncompatibleValues
     * @expecedExceptionMessage minimum_should_match and low_freq / high_freq are incompatible. Please refer to the manual
     */
    public function minimumShouldMatchAndLowFreqIncompatibleValues()
    {
        $this->query->setQuery('This is some query text');
        $this->query->setMinimumShouldMatch(2);
        $this->query->setLowFreq(50);
        $this->containerise($this->query);
    }

    /**
     * @test
     * @expectedException tantrum_elastic\Exception\IncompatibleValues
     * @expecedExceptionMessage minimum_should_match and low_freq / high_freq are incompatible. Please refer to the manual
     */
    public function minimumShouldMatchAndHighFreqIncompatibleValues()
    {
        $this->query->setQuery('This is some query text');
        $this->query->setMinimumShouldMatch(2);
        $this->query->setHighFreq(50);
        $this->containerise($this->query);
    }


    // Utils

    public function setUp()
    {
        $this->query = new CommonTerms();
        $this->baseExpectation = [
            'common' => [
                'body' => [
                    'cutoff_frequency' => null,
                    'low_freq_operator' => null,
                    'minimum_should_match' => [
                        'high_freq' => null,
                        'low_freq' => null,
                    ],
                    'query' => null,
                ],
            ],
        ];
    }

    // Data Providers

    public function lowFreqOperatorsDataProvider()
    {
        return [
            ['or'],
            ['and'],
        ];
    }
}
