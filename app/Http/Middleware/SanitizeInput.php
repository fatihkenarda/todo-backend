<?php

namespace App\Http\Middleware;

use Closure;

class SanitizeInput
{
    public function handle($request, Closure $next)
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$inputValue) {
            if (is_string($inputValue)) {
                // HTML ve JS etiketlerini temizle
                $inputValue = strip_tags($inputValue);
                // Baş ve sondaki boşlukları temizle
                $inputValue = trim($inputValue);
            }
        });

        $request->merge($input);

        return $next($request);
    }
}