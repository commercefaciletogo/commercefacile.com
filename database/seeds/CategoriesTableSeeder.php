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
        DB::table('categories')->truncate();
        DB::table('categories')->insert($this->get_data());
    }

    private function get_data(){
        return collect($this->get_categories())->map(function($cat){
            return [
                'name' => title_case($cat),
                'slug' => str_slug($cat)
            ];
        })->toArray();
    }

    private function get_categories(){
        return [
            'Electronics',
            'Vehicles',
            'Fashion & Beauty',
            'Education',
            'Food and agriculture',
            'Construction & Industrial',
            'Animals & Pets',
            'Home, Furniture & Garden',
            'Real Estate',
            'Hobby, Art & Sport',
            'Other',
//            'Jobs & Services',
        ];
    }
}
