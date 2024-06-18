<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CheckLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } elseif (Cookie::has('locale')) {
            $locale = Cookie::get('locale');
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            $defaultLocale = config('app.locale');
            App::setLocale($defaultLocale);
            Session::put('locale', $defaultLocale);
        }

        return $next($request);
    }
}
