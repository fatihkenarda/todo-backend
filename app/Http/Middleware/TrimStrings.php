<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * Trimleme işleminden hariç tutulan alanlar.
     */
    protected $except = [
        
    ];
}