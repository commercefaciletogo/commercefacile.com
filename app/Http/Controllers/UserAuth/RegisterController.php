<?php

namespace App\Http\Controllers\UserAuth;

use App\User;
use Ramsey\Uuid\Uuid;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user.guest');
    }

    public function registerUser()
    {
        $data = request()->all();
        $this->validator($data)->validate();

        if($this->sendCode(request('phone'))){
            session()->put('user_registration_data', $data);
            return response()->json(['sent' => true]);
        }
        return response()->json(['sent' => false]);
    }

    private function sendCode($phone)
    {
        $code = '1234';
//        $code = $this->generate_random();
//        after sending the code to user phone
//        if(! SMSService.sent($phone, $code)){
//            return false;
//        }
        session()->put('code', $code);
        return true;
    }

    public function authenticatePhone()
    {
        $submitted_code = request()->get('code');
        $sent_code = session()->get('code');
        $matched = $submitted_code == $sent_code;

        if(!$matched){
            return response()->json(['code' => 'no match'])->setStatusCode(422);
        }

        $user = $this->add_user(session('user_registration_data'));
        Auth::guard('user')->login($user);
        return response()->json(['done' => $matched, 'url' => $this->get_user_profile_url($user->slug)]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'phone' => 'required|regex:/[0-9]{8}/|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $uuid = Uuid::uuid4();
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'uuid' => $uuid
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('user.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('user');
    }

    private function saveUser()
    {
        $user_data = session('user');


    }

    private function generate_random($digits = 4)
    {
        return rand(pow(10, $digits - 1), pow(10, $digits)-1);
    }

    /**
     * @param $user_data
     * @return static
     */
    private function add_user($user_data)
    {
        $uuid = Uuid::uuid4();
        $attributes = collect($user_data)
            ->put('slug', str_slug("{$user_data['name']} {$user_data['phone']}"))
            ->put('password', bcrypt($user_data['password']))
            ->put('uuid', $uuid)
            ->all();
        return User::create($attributes);
    }

    /**
     * @param $name
     * @return string
     */
    private function get_user_profile_url($name)
    {
        return session('url.intended') ?: route('user.profile', ['user_name' => $name]);
    }
}
