<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Locale is enabled and allowed to be change
        $language_code = app(config('constants.CACHE.SYSTEM.LANGUAGE'))->pluck('code')->toArray();
        // Check if the user is authenticated
        if (Auth::check()) {
            if (Auth::user()->language && in_array(Auth::user()->language, $language_code)) {
                app()->setLocale(Auth::user()->language);
            }
        } else {
            $systemSettings = app(config('constants.CACHE.SYSTEM.SETTINGS'));
            // Set the application's locale
            app()->setLocale($systemSettings['language']);
        }

        return $next($request);
    }
}
