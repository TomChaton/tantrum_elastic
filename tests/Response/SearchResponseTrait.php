<?php

namespace tantrum_elastic\tests\Response;

trait SearchResponseTrait
{
    /** @var array $emptySearchResult */
    protected $emptySearchResult = [
        'took'      => 1,
        'timed_out' => false,
        '_shards'    => [
            'total'      => 5,
            'successful' => 5,
            'failed'     => 0,
        ],
        'hits' => [
            'total'     => 0,
            'max_score' => 0,
            'hits'      => []
        ],
    ];
}
