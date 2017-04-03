<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->truncate();
        DB::table('locations')->insert($this->get_data());
    }

    private function get_data()
    {
        return collect($this->get_locations())->map(function($city){
            return [
                'name' => title_case($city['name']),
                'slug' => str_slug($city['name']),
                'parent_id' => $city['parent_id']
            ];
        })->toArray();
    }

    private function get_locations()
    {
        return [

//      regions
            ['name' => 'Maritime', 'parent_id' => null],
            ['name' => 'Plateau', 'parent_id' => null],
            ['name' => 'Kara', 'parent_id' => null],

//      cities
//          maritime
            ['name' => 'ablogamé', 'parent_id' => 1],
            ['name' => 'amoutivé', 'parent_id' => 1],
            ['name' => 'forever', 'parent_id' => 1],
            ['name' => 'kodjoviakopé', 'parent_id' => 1],
            ['name' => 'lomé II', 'parent_id' => 1],
            ['name' => 'noukafou', 'parent_id' => 1],
            ['name' => 'tokoin', 'parent_id' => 1],
            ['name' => 'xédranawoe', 'parent_id' => 1],

//            kara
//            ['name' => 'ablogamé', 'parent_id' => 3],
        ];
    }
}
