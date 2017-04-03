<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use App\Location;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PagesController extends Controller
{
    /**
     * @var Location
     */
    private $location;

    /**
     * PagesController constructor.
     * @param Location $location
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function home()
    {
        $categories = Category::whereNull('parent_id')->get()->map(function($cat){
            $cat = $cat->translate();
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'key' => $cat->key
            ];
        });
        $cities = $this->location->whereNotNull('parent_id')->take(7)->get();
        return view('pages.home.index', ['categories' => $categories, 'cities' => $cities]);
    }
}
