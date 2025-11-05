<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfUnauthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('sanctum')->check()) {
            // If the request is for API, return JSON
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated. Redirecting to login.'], 401);
            }

            // Otherwise, redirect to /login page
            return redirect('/login');
        }

        return $next($request);
    }
}
