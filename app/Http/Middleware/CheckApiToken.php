<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->input('token') ?? $request->header('token');
        $apiToken = config('app.api_token');
        if ($token == $apiToken) {
            return $next($request);
        }
        if (decrypt($token) === $apiToken) {
            return $next($request);
        }
        return response()->json([
            'data' => null,
            'msg' => 'Forbidden',
            'code' => 403,
        ], 403);
    }
}
