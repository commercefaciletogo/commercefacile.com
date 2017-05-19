<?php

namespace App\Http\Controllers\UserAuth;

use App\Notifications\PhoneConfirmation;
use App\User;
use App\AgentMeta;
use App\AgentSubscriber;
use Bjrnblm\Messagebird\Facades\Messagebird;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\Messagebird\MessagebirdMessage;
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

    const C_FACILE = "C FACILE";
    use RegistersUsers;
    use Notifiable;

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

        // $sendCode = $this->sendCode(request('phone'));
        $sendCode = true;
        session()->put('code', '1234');

        if($sendCode == true){
            session()->put('user_registration_data', array_add($data, 'status', 'active'));
            $token = Uuid::uuid4();
            session()->put('token', $token);
            return redirect()->route('user.get.phone.verify', ['token' => $token]);
        }
        return redirect()->back();
    }

    private function sendCode($phone)
    {
        try{
            $code = $this->generate_random();
            $message = trans('auth.sms', ['code' => $code]);
            $recipients = ["00228{$phone}"];
            Messagebird::createMessage(self::C_FACILE, $recipients, $message);
            session()->put('code', $code);
            return true;
        }catch (\Exception $e){
            return false;
        }
    }

    public function showCodeForm($token)
    {
        $t = session()->get('token');
        if($t != $token) return redirect()->back();

        return view('user.auth.code');        
    }

    public function authenticatePhone()
    {
        $this->validate(request(), ['code' => 'required|min:4|max:4']);
        $submitted_code = request()->get('code');
        $sent_code = session()->get('code');
        $matched = $submitted_code == $sent_code;

        if(!$matched){
            return redirect()->back()->withErrors(['code' => trans('validation.custom.code.same')]);
        }

        $user = $this->add_user(session('user_registration_data'));

        if(session()->has('agent')){
            $agent = session()->get('agent');
            AgentSubscriber::create(['agent_id' => $agent->id, 'user_id' => $user->id]);
            session()->forget('agent');
        }

        Auth::guard('user')->login($user);
        return redirect($this->get_user_profile_url($user->slug));
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
        if(request()->has('a')){
            $agent_token = request()->get('a');
            $meta = AgentMeta::where('token', $agent_token)->first();
            if(!$meta) return;

            $agent = $meta->agent;
            if(!$agent) return;
            session()->put('agent', $agent); 
        }
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

    private function generate_random()
    {
        $digits = 4;
        return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
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
