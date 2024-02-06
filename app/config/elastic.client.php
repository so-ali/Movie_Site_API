<?php declare(strict_types=1);

return [
    'default' => env('ELASTIC_CONNECTION', 'default'),
    'connections' => [
        'default' => [
            'hosts' => [
                env('ELASTICSEARCH_HOST').':'.env('ELASTICSEARCH_PORT'),
            ],
        ],
    ],
];
