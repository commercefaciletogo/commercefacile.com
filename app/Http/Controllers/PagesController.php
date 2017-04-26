<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Category;
use App\City;
use App\Commerce\Transformers\AdsTransformer;
use App\Location;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PagesController extends Controller
{
    /**
     * @var Location
     */
    private $location;
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * PagesController constructor.
     * @param Location $location
     * @param Manager $fractal
     */
    public function __construct(Location $location, Manager $fractal)
    {
        $this->location = $location;
        $this->fractal = $fractal;
    }

    public function home()
    {
        $categories = Category::whereNull('parent_id')->get()->map(function($cat){
            $cat = $cat->translate();
            return [
                'id' => $cat->id,
                'uuid' => $cat->uuid,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'key' => $cat->key
            ];
        });
        $cities = $this->location->whereNotNull('parent_id')->take(7)->get();
        $latest_ads = $this->get_latest_ads();
        return view('pages.home.index', ['categories' => $categories, 'cities' => $cities, 'latest' => $latest_ads]);
    }

    public function sell()
    {
        return view('pages.misc.sell');
    }

    public function about()
    {
        return view('pages.misc.about');
    }

    public function contact()
    {
        return view('pages.misc.contact');
    }

    public function safe()
    {
        return view('pages.misc.safe');
    }

    public function faq()
    {
        return view('pages.misc.faq');
    }

    public function privacy()
    {
        return view('pages.misc.privacy');
    }

    public function terms()
    {
        return view('pages.misc.terms');
    }

    /**
     * @return array
     */
    private function get_latest_ads()
    {
        return Category::with('ads')->get()->sortByDesc(function(Category $category){
                return $category->ads->filter(function(Ad $ad){
                    return $ad->status == 'online';
                })->count();
            })->take(3)
            ->map(function(Category $category){
                $trans_category = $category->translate();
                return [
                    $trans_category['name'] => $this->get_category_latest_ads($category)
                ];
            })
            ->flatMap(function($c){
                return $c;
            })
            ->all();
    }

    /**
     * @param Category $category
     * @return mixed
     */
    private function get_category_latest_ads(Category $category)
    {
        $ads = $category->ads
            ->where('status', 'online')
            ->sortByDesc(function($ad){
            return $ad['start_date'];
        });
        return $this->fractal->createData(new Collection($ads, new AdsTransformer))->toArray()['data'];
    }
}
