<?php

namespace App\Http\Middleware;

use Closure;
use Commerce\Helpers\Lang;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $country = geoip()->getLocation()->getAttribute('country');
        $locale = (new Lang($country))->get();
        App::setLocale($locale);
        return $next($request);
    }
}
