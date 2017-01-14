<?php

namespace App\Http\Middleware;

use App\Country;
use Closure;

class CountryMiddleware
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
        $country_id = 1;
//        $c = geoip()->getLocation()->getAttribute('country');
//        $country = Country::where('name', $c)->first();
//        if($country) $country_id = $country->id;
        session()->put('country_id', $country_id);
        return $next($request);
    }
}
