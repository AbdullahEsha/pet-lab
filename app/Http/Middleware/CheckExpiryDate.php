<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckExpiryDate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = $request->user();
            if ($user->subExpDate !== null) {
                $subExpDate = strtotime($user->subExpDate);
                $currentDate = strtotime(date('Y-m-d'));
                if ($subExpDate < $currentDate) {
                    return response()->json(['message' => 'Subscription expired!'], Response::HTTP_UNAUTHORIZED);
                }
            }
            return $next($request);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
