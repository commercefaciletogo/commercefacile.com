<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotLogIn
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
        $user_name = $request->user_name;
        if (Auth::guard('user')->guest()) {
            return redirect()->route('user.profile.public', ['user_name' => $user_name]);
        }
        return $next($request);
    }
}
