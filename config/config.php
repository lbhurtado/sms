<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The default SMS Driver
    |--------------------------------------------------------------------------
    |
    | The default sms driver to use as a fallback when no driver is specified
    | while using the SMS component.
    |
    */
    'default' => env('SMS_DRIVER', 'engagespark'),

    /*
    |--------------------------------------------------------------------------
    | Nexmo Driver Configuration
    |--------------------------------------------------------------------------
    |
    | We specify key, secret, and the number messages will be sent from.
    |
    */
    'nexmo' => [
        'key' => env('NEXMO_KEY', ''),
        'secret' => env('NEXMO_SECRET', ''),
        'from' => env('NEXMO_SMS_FROM', '')
    ],

    'engagespark' => [
        'api_key' => env('ENGAGESPARK_API_KEY'),
        'org_id' => env('ENGAGESPARK_ORGANIZATION_ID'),
        'sender_id' => env('ENGAGESPARK_SENDER_ID', 'serbis.io'),
        'end_points' => [
            'sms' => env('ENGAGESPARK_SMS_ENDPOINT', 'https://start.engagespark.com/api/v1/messages/sms'),
            'topup' => env('ENGAGESPARK_AIRTIME_ENDPOINT', 'https://api.engagespark.com/v1/airtime-topup'),
        ],
    ],

//    /*
//    |--------------------------------------------------------------------------
//    | Twilio Driver Configuration
//    |--------------------------------------------------------------------------
//    |
//    | We specify key, secret, and the number messages will be sent from.
//    |
//    */
//    'twilio' => [
//        'key' => env('TWILIO_KEY', ''),
//        'secret' => env('TWILIO_SECRET', ''),
//        'from' => env('TWILIO_SMS_FROM', '')
//    ],
];
