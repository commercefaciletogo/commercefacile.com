<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }

    private function get_data(){
        collect($this->get_cities())->map(function($city){
            return [
                'name' => $city['name'],
                'slug' => str_slug($city['name']),
                'region_id' => $city['region_id']
            ];
        })->toArray();
    }

    private function get_cities(){
        return [
            ['name' => 'lome - bè', 'region_id' => 1],
            ['name' => 'lome - ablogamé', 'region_id' => 1],
            ['name' => 'lome - amoutivé', 'region_id' => 1],
            ['name' => 'lome - forever', 'region_id' => 1],
            ['name' => 'lome - kodjoviakopé', 'region_id' => 1],
            ['name' => 'lome - lomé II', 'region_id' => 1],
            ['name' => 'lome - noukafou', 'region_id' => 1],
            ['name' => 'lome - tokoin', 'region_id' => 1],
            ['name' => 'lome - xédranawoe', 'region_id' => 1],
            ['name' => 'lome - tokoin', 'region_id' => 1],
//            ['name' => 'lome - tokoin', 'region_id' => 1],
        ];
    }
}
