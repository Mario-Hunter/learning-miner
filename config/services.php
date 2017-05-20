<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
    'domain' => env('MAILGUN_DOMAIN'),
    'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
    'key' => env('SES_KEY'),
    'secret' => env('SES_SECRET'),
    'region' => 'us-east-1',
    ],

    'sparkpost' => [
    'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
    'model' => App\User::class,
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
    'client_id' => '1361512743925513',
    'client_secret' => '9ed5cf75ebb02591b122253f36658a20',
    'redirect' => 'http://localhost:8000/callback/facebook',
    ],

    'google'=>[
    'client_id' => '103995467475-34cn6rsbaipahj1ng63l68f2747cpglv.apps.googleusercontent.com',
    'client_secret' => 'l78r7GY2J7CqjGOXlh5saN1J',
    'redirect' => 'http://localhost:8000/callback/google',
    ]

    ];
