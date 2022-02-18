<?php

return [
    'uri' => env('MOBILEPAY_URI', 'https://api.sandbox.mobilepay.dk'),
    'api_key' => env('MOBILEPAY_API_KEY'),
    'client_id' => env('MOBILEPAY_CLIENT_ID'),
    'timeout' => env('MOBILEPAY_TIMEOUT', 10),
    'retry' => [
        'times' => env('MOBILEPAY_RETRY_TIMES', null),
        'sleep' => env('MOBILEPAY_RETRY_SLEEP', null),
    ]
];
