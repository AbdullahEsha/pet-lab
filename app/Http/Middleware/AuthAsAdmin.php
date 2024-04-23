<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // check if the user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // check if the user is an admin
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Forbidden'
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
