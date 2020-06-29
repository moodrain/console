<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->input('token') ?? $request->header('token');
        if ($token == config('app.api_token')) {
            return $next($request);
        }
        if (decrypt($token) === config('app.api_token')) {
            return $next($request);
        }
        abort(403);
    }
}
