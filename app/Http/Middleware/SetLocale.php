<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $availableLocales = ['id', 'en'];
        $defaultLocale = in_array(config('app.locale'), $availableLocales, true)
            ? config('app.locale')
            : 'id';

        $requestedLocale = $request->query('lang');

        if (is_string($requestedLocale) && in_array($requestedLocale, $availableLocales, true)) {
            $request->session()->put('locale', $requestedLocale);
        }

        $locale = $request->session()->get('locale', $defaultLocale);

        if (! in_array($locale, $availableLocales, true)) {
            $locale = $defaultLocale;
        }

        App::setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
