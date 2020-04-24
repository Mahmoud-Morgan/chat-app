<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'pusher'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => 'a511972f235b6f1f8f0c',
            'secret' => 'e82083b10f63e53ac67c',
            'app_id' => '988243',
            'options' => [
                'cluster' => 'eu',
                'useTLS' => true,
                // 'host' => '127.0.0.1',
                // 'port' => 6001,
                // 'scheme' => 'http',
                //  'curl_options' => [
                //     CURLOPT_SSL_VERIFYHOST => 0,
                //     CURLOPT_SSL_VERIFYPEER => 0,
                // ]
                    ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
