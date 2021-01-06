<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AcceptLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = config('app.locale');

        if ($request->hasHeader('Accept-Language')) {
            $header_locale = $request->header('Accept-Language');
            in_array($header_locale, config('app.locales_available')) ? $locale = $header_locale : true;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
