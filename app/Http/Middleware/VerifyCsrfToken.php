<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseMiddleware;

class VerifyCsrfToken extends BaseMiddleware
{
    protected $addHttpCookie = true;
    protected $except = [
        '/patient'
    ];

    public function handle($request, Closure $next)
    {
        return parent::handle($request, $next);
    }
}
