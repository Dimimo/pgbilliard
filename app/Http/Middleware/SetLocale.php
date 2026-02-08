<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('locale')) {
            $locale = $request->get('locale', \Illuminate\Support\Facades\Config::get('app.locale'));
        } elseif ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale', \Illuminate\Support\Facades\Config::get('app.locale'));
        } else {
            $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        }

        //fallback language if the language is not available
        if (!in_array($locale, \Illuminate\Support\Facades\Config::get('app.available_locales'))) {
            $locale = \Illuminate\Support\Facades\Config::get('app.fallback_locale');
        }

        \App::setLocale($locale);
        $request->session()->put('locale', $locale);

        return $next($request);
    }
}
