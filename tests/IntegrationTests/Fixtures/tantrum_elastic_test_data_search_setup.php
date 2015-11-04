<?php

return [
    'mappings' => [
        'collision' => [
            'properties' => [
                'vehicleType' => [
                    'type'  => 'string',
                    'index' => 'not_analyzed'
                ],
                'id' => [
                    'type'  => 'long',
                    'index' => 'not_analyzed'
                ],
            ],
        ],
    ],
];
