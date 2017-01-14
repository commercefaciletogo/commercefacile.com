<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert($this->get_data());
    }

    private function get_data(){
        collect($this->get_categories())->map(function($cat){
            return [
                'name' => $cat,
                'slug' => str_slug($cat)
            ];
        })->toArray();
    }

    private function get_categories(){
        return [
            'electronics',
            'vehicles',
            'jobs and services',
            'fashion and beauty',
            'education',
            'food and agriculture',
            'construction and industrial',
            'animal and pets',
            'home, furniture and garden',
            'real estate',
            'hobby, art and sport',
            'other',
        ];
    }
}
