<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/chet/bot/api',
        '/sendgrid/events',
        '/find-journalist',
        '/save-journalist',
        '/news-alerts/last-alert',
        '/ajax/request-s3-file-signature',
        '/view-video/{userId}/{videoId}',
        '/check-url-good-for-iframe',
        'stripe/*',
    ];
}
