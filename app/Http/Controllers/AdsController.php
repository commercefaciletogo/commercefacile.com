<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function multiple()
    {
        return view('pages.ads.multiple');
    }

    public function single($id){}

    public function create()
    {
        return view('pages.ads.create');
    }

    public function save(){}

    public function edit($id){}

    public function delete($id){}
}
