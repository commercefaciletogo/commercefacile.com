<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use App\Region;
use App\City;

class LocationsController extends Controller
{
    /**
     * @var Location
     */
    private $location;


    /**
     * LocationsController constructor.
     * @param Location $location
     */
    public function __construct(Location $location){
        $this->location = $location;
    }

    public function index()
    {
        $regions = $this->location->with('children')->whereNull('parent_id')->get();

        $locations = collect($regions)->map(function($region){
            return [
                'id' => $region->id,
                'name' => $region->name,
                'children' => $region->children,
                'icon' => "/img/icons/city.png",
            ];
        });

        return response()->json($locations);
    }

    public function cities($id)
    {
        $cities = $this->location->with('children')->find($id)->children;
        return response()->json($cities);
    }
}
