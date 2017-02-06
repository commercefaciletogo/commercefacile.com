<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('pages.home.index', ['categories' => $categories]);
    }
}
