<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function profile($user_name)
    {
        return view('user.profile');
    }

    public function settings($user_name)
    {
        return view('user.settings');
    }

    public function favorites($user_name)
    {
        return view('user.favorites');
    }
}
