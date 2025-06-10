<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * CSRF doğrulamasından muaf tutulacak URI’ler.
     *
     * @var array<int, string>
     */
    protected $except = [
        // API istekleri için CSRF koruması kapatılacaksa buraya yollar eklenebilir
        'api/*',
    ];
}