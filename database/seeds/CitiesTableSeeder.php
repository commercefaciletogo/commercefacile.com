<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->truncate();
        DB::table('cities')->insert($this->get_data());
    }

    private function get_data(){
        return collect($this->get_cities())->map(function($city){
            return [
                'name' => $city['name'],
                'slug' => str_slug($city['name']),
                'region_id' => $city['region_id']
            ];
        })->toArray();
    }

    private function get_cities(){
        return [
            ['name' => 'bè', 'region_id' => 1],
            ['name' => 'ablogamé', 'region_id' => 1],
            ['name' => 'amoutivé', 'region_id' => 1],
            ['name' => 'forever', 'region_id' => 1],
            ['name' => 'kodjoviakopé', 'region_id' => 1],
            ['name' => 'lomé II', 'region_id' => 1],
            ['name' => 'noukafou', 'region_id' => 1],
            ['name' => 'tokoin', 'region_id' => 1],
            ['name' => 'xédranawoe', 'region_id' => 1],
//            ['name' => 'lome - tokoin', 'region_id' => 1],
//            ['name' => 'lome - tokoin', 'region_id' => 1],
        ];
    }
}
