<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user.guest', ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        $this->validateInput($request);
        $attempt = $this->attempt($request);
        if ($attempt) {
            return redirect()->intended($this->redirectPath());
        }

        return $this->returnFailedResponse($request);
    }

    private function validateInput(Request $request)
    {
        $this->validate($request, [
            'username' => 'required', 'password' => 'required',
        ]);
    }

    private function attempt(Request $request)
    {
        $credentials = $this->get_credentials($request);
        return $this->guard()->attempt(
            $credentials, $request->has('remember')
        );
    }

    private function returnFailedResponse(Request $request)
    {
        $request->session()->flash('error', true);
        return redirect()->back()
            ->withInput($request->only('username', 'remember'));
    }

    public function redirectPath()
    {
        return route('user.profile', ['user_name' => $this->guard()->user()->slug]);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('user.auth.login');
    }


    private function get_credentials(Request $request)
    {
        $username = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        return [
            $username => $request->username,
            'password' => $request->password
        ];
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('user');
    }

    public function logoutToPath() {
        return route('home.page');
    }
}
