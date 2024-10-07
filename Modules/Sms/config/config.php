<?php

return [
    'name'      => 'Sms',
    'kavenegar' => [
        'key'    => env('KAVENEGAR_API_KEY'),
        'sender' => env('KAVENEGAR_SENDER')
    ],

    'sms-ir' => [
        'key'      => env('SMS_IR_API_KEY'),
        'username' => env('SMS_IR_USERNAME'),
        'sender'   => env('SMS_IR_SENDER')
    ]
];
