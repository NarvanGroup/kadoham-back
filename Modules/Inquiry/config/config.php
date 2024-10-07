<?php

return [
    'name' => 'Inquiry',

    'ehraz' => [
        'providers' => [
            'master' => env('EHRAZ_MASTER_PROVIDER', 'Ehraz'),
            'slave' => env('EHRAZ_SLAVE_PROVIDER', 'Jibit')
        ],
    ],

    'ehrazio' => [
        'url' => env('EHRAZIO_URL'),
        'token' => env('EHRAZIO_TOKEN')
    ],
    'jibit' => [
        'url' => env('JIBIT_URL'),
        'token' => env('JIBIT_TOKEN')
    ],
    'shepa' => [
        'url' => env('SHEPA_URL'),
    ],
];
