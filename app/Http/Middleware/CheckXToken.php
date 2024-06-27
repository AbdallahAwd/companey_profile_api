<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckXToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the 'x-token' header is present
        if ($request->header('x-token') !== "arabian_bureau-of_services") {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);

    }
}
