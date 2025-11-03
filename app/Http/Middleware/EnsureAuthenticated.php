<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!AuthHelper::isAuthenticated()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // Optional: Verify token with backend (uncomment if needed)
        // if (!AuthHelper::verifyToken()) {
        //     AuthHelper::clearAuth();
        //     return redirect()->route('login')
        //         ->with('error', 'Session expired, please login again');
        // }

        return $next($request);
    }
}
