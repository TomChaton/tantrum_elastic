<?php

namespace tantrum_elastic\Response;

use tantrum_elastic\Lib;

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

    /** @var tantrum_elastic\Lib\DocumentCollection */
    private $documents;

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

    private function setDocuments(array $hits)
    {
        $this->documents = new Lib\DocumentCollection();
        $this->documents->buildFromArray($hits);
        return true;
    }

    public function getDocuments()
    {
        return $this->documents;
    }
}
