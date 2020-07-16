<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'facebook' => [
        'client_id' => '546279472610387',
        'client_secret' => 'fd360a80d5e570c845df1e9531a1afa3',
        'redirect' => env('APP_URL') . '/callback/facebook',
    ],
    'github' => [
        'client_id' => 'Iv1.9813f4cd76d88deb',
        'client_secret' => '8b8145d826c58ffbbcc658967dc15b736ee81e9b',
        'redirect' => env('APP_URL') . '/callback/github',
    ],
    'google' => [
        'client_id' => '127638244550-v967egtu1p39c3p9dnjd98gnmhj6e4dq.apps.googleusercontent.com',
        'client_secret' => 'ixjZdfgESebFBiCHW0jFYccZ',
        'redirect' => env('APP_URL') . '/callback/google',
      ], 
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
