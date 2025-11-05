<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's middleware aliases.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        // ...existing middleware aliases...
        'jabatan' => \App\Http\Middleware\JabatanMiddleware::class,
    ];

    // ...existing code...
}