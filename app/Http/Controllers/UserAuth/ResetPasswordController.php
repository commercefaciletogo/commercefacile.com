<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user.guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token = null)
    {
        if(is_null($token)) return redirect()->back();

        if($token != session('pass_token')) return redirect()->back();

        return view('user.auth.passwords.reset');
    }

    public function reset(Request $request)
    {
        $code = session('code');
        if($code != $request->code) return redirect()->back()->withErrors(['code' => 'Invalid Code']);

        $this->validate($request, [
            'password' => 'required|confirmed',
        ]);

        $user = User::where('phone', session('phone'))->first();
        if(is_null($user)) return redirect()->back();

        $user->update(['password' => bcrypt($request->password)]);

        session()->flush();

        return redirect()->route('user.get.login');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('users');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('user');
    }
}
