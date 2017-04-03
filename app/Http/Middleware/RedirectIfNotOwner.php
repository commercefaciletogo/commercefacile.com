<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotOwner
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
        if (Auth::guard('user')->check() && !$this->user_is_owner(Auth::guard('user')->user(), $user_name)) {
            return redirect()->route('user.profile.public', ['user_name' => $user_name]);
        }
        return $next($request);
    }

    /**
     * @param $user
     * @param $user_name
     * @return bool
     */
    private function user_is_owner($user, $user_name)
    {
        return $user->slug == $user_name;
    }
}
