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
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('SECRET_KEY'),
    ],

    'sendgrid' => [
        'api_key' => env('SENDGRID_API_KEY'),
    ],

    'facebook' => [
        'client_id' => '210901899607808',
        'client_secret' => 'deac2f2815fbaf2f4f806e3722907626',
        'redirect' => 'http://hooty.co/facebook/success',
    ],

    'linkedin' => [
        'client_id' => '86epqureu4ni28',
        'client_secret' => 'RW6H5DYxYiTSqKDf',
        'redirect' => 'http://hooty.co/linkedin/success',
    ],

];
