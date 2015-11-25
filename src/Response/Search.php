<?php

namespace tantrum_elastic\Response;

use tantrum_elastic\Lib;
use tantrum_elastic\Document\Collection;

/**
 * This class is the response handler for search api responses
 * @package tantrum_elastic\Response
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.0/search-request-body.html
 */
class Search extends Base
{
    const KEY_HITS = 'hits';

    const SUB_KEY_HITS      = 'hits';
    const SUB_KEY_TOTAL     = 'total';
    const SUB_KEY_MAX_SCORE = 'max_score';

    private static $expectedKeys = [
        self::KEY_HITS,
    ];

    private static $expectedSubKeys = [
        self::KEY_HITS => [
            self::SUB_KEY_HITS,
            self::SUB_KEY_TOTAL,
            self::SUB_KEY_MAX_SCORE,
        ],
    ];

    /** @var integer */
    private $totalDocuments;

    /** @var float */
    private $maxScore;

    /** @var Collection */
    private $documents;

    /**
     * Validates and hydrates the class. Called by parent
     *
     * @param  array  $response The array response received from es
     *
     * @return boolean
     */
    protected function validateAndSetResponseArray(array $response)
    {
        $this->validateKeys(self::$expectedKeys, $response);
        foreach (self::$expectedSubKeys as $key => $subKeys) {
            $this->validateKeys($subKeys, $response[$key]);
        }
        
        $this->totalDocuments = $response[self::KEY_HITS][self::SUB_KEY_TOTAL];
        $this->maxScore       = $response[self::KEY_HITS][self::SUB_KEY_MAX_SCORE];
        $this->setDocuments($response[SELF::KEY_HITS][self::SUB_KEY_HITS]);

        return true;
    }

    /**
     * Creates a new document collection and hydrates it from the response array
     *
     * @param array $hits
     *
     * @return boolean
     */
    private function setDocuments(array $hits)
    {
        $this->documents = $this->container->get('tantrum_elastic\Document\Collection');
        $this->documents->buildFromArray($hits);
        return true;
    }

    /**
     * Get the document collection
     *
     * @return DocumentCollection
     */
    public function getDocuments()
    {
        return $this->documents;
    }
}
