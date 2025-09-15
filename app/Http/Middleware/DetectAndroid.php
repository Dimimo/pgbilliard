<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectAndroid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user agent contains "android"
        if (stripos($request->header('User-Agent'), 'android') !== false) {
            // User is on an Android device
            // You can perform actions here, like setting a session variable or logging
            session(['is_android' => true]);
        } else {
            session(['is_android' => false]);
        }

        return $next($request);
    }
}
