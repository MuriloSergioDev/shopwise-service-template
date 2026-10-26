<?php

declare(strict_types=1);

use App\Messaging\Handlers\PingedHandler;

return [
    'source' => env('SERVICE_NAME', 'ping'),

    'consumer_group' => env('KAFKA_CONSUMER_GROUP_ID', env('SERVICE_NAME', 'ping')),

    // Event type => handler. Every type listed here needs its topic in deploy/values.yaml → consumers.
    'handlers' => [
        'platform.pinged' => PingedHandler::class,
    ],

    'max_attempts' => 3,

    'relay_batch_size' => 100,
];
