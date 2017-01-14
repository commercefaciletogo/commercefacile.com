<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert($this->get_regions());
    }

    private function get_data(){
        collect($this->get_regions())->map(function($region){
            return [
                'name' => $region['name'],
                'country_id' => $region['country_id'],
                'slug' => str_slug($region['name'])
            ];
        })->toArray();
    }

    private function get_regions()
    {
        return [
            ['name' => 'maritime', 'country_id' => 1],
            ['name' => 'kara', 'country_id' => 1],
            ['name' => 'plateau', 'country_id' => 1],
        ];
    }
}
