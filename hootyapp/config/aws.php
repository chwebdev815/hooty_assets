<?php

//use Aws\Laravel\AwsServiceProvider;
return [
    'credentials' => [
        'key'    => 'AKIAJVBMNWVE6YMD7XPA',
        'secret' => '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',
    ],
    'region' => 'us-west-2',
    'version' => 'latest',
    
    // You can override settings for specific services
    'Ses' => [
        'region' => 'us-west-2',
    ],
];