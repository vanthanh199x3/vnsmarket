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

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'github' => [
        'client_id' => '24fbd0edd46019058da7', //Github API
        'client_secret' => '4500e6ab7a9bb70608600fbdee37969276bb0685', //Github Secret
        'redirect' => 'http://localhost:8000/login/github/callback',
     ],
     'google' => [
        'client_id' => '970319522923-jnsm9fpbt812q17jh77i4279d3v2pnb4.apps.googleusercontent.com', //Google API
        'client_secret' => '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', //Google Secret
        'redirect' => env('APP_URL').'/login/google/callback',
     ],
     'facebook' => [
        'client_id' => '532929318330063', //Facebook API
        'client_secret' => 'e1934b18cd79ad1c8761e05484c45185', //Facebook Secret
        'redirect' => env('APP_URL').'/login/facebook/callback',
     ],

];
