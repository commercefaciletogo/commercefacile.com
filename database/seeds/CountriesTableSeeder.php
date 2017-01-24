<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->truncate();
        foreach ($this->get_countries() as $country){
            DB::table('countries')->insert([
                'name' => $country,
                'slug' => str_slug($country)
            ]);
        }
    }

    private function get_countries(){
        return [
            'togo',
            'benin'
        ];
    }
}
