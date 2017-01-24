<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Region;
use App\City;

class LocationsController extends Controller
{
    private $region;

    private $city;


    public function __construct(Region $region, City $city){
        $this->region = $region;
        $this->city = $city;
    }

    public function index()
    {
        $regions = $this->region->with('cities')->get();

        $locations = collect($regions)->map(function($region){
            return [
                'id' => $region->id,
                'name' => $region->name,
                'children' => $region->cities
            ];
        });

        return response()->json($locations);
    }
}
