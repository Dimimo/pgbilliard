<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('is_admin')) {
            $count = \DB::table('admins')->where('user_id', '=', auth()->id())->count();
            session()->put('is_admin', $count === 1);
        }

        return $next($request);
    }
}
