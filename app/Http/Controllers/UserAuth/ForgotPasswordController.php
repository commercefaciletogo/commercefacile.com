<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use App\Notifications\PhoneConfirmation;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Password;
use Ramsey\Uuid\Uuid;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails, Notifiable;

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
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('user.auth.passwords.email');
    }

    public function sendResetCode(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|digits:8|exists:users'
        ]);

        $code = $this->generate_code();
        $phone = "00228{$request->phone}";
        $this->notify(new PhoneConfirmation($phone, $code));
        session()->put('code', 1234);
        session()->put('phone', $request->phone);
        // send code to user

        $token = Uuid::uuid4();
        session()->put('pass_token', $token);
        return redirect()->route('user.get.reset.pass', ['token' => $token]);
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
     * @return string
     */
    private function generate_code()
    {
        $digits = 4;
        return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    }
}
