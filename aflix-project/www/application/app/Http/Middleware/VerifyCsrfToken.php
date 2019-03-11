<?php

namespace HelloVideo\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'stripe/webhook', 'admin/plugin/*', 'api/*', 'ipn', 'admin/media/*' , 'api/v1/*'
    ];
}
