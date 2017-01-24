<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategoriesTableSeeder extends Seeder
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
        return collect($this->get_sub_categories())->map(function($s_c){
            return [
                'name' => title_case($s_c['name']),
                'slug' => str_slug($s_c['name']),
                'parent_id' => $s_c['category_id']
            ];
        })->toArray();
    }

    private function get_sub_categories(){
        return [
            ['name' => 'mobile phones', 'category_id' => 1],
            ['name' => 'mobile phone accessories', 'category_id' => 1],
            ['name' => 'computers and tablets', 'category_id' => 1],
            ['name' => 'computers accessories', 'category_id' => 1],
            ['name' => 'tvs', 'category_id' => 1],
            ['name' => 'tv and video accessories', 'category_id' => 1],
            ['name' => 'cameras', 'category_id' => 1],
            ['name' => 'audio and mp3', 'category_id' => 1],
            ['name' => 'other electronics', 'category_id' => 1],

            ['name' => 'car accessories', 'category_id' => 2],
            ['name' => 'cars', 'category_id' => 2],
            ['name' => 'motorcycles', 'category_id' => 2],
            ['name' => 'other vehicles', 'category_id' => 2],
            ['name' => 'bicycles', 'category_id' => 2],

            ['name' => 'offered jobs', 'category_id' => 3],
            ['name' => 'seeking jobs', 'category_id' => 3],
            ['name' => 'services', 'category_id' => 3],

            ['name' => 'clothing and shoes', 'category_id' => 4],
            ['name' => 'health and beauty', 'category_id' => 4],
            ['name' => 'watches, jewelry and accessories', 'category_id' => 4],
            ['name' => 'other personal items', 'category_id' => 4],

            ['name' => 'textbooks', 'category_id' => 5],
            ['name' => 'teaching and training', 'category_id' => 5],
            ['name' => 'other education', 'category_id' => 5],

            ['name' => 'food', 'category_id' => 6],
            ['name' => 'crops, seeds and plants', 'category_id' => 6],
            ['name' => 'chemical, tools and machinery', 'category_id' => 6],
            ['name' => 'other food and agriculture', 'category_id' => 6],

            ['name' => 'construction tools and equipment', 'category_id' => 7],
            ['name' => 'construction and building materials', 'category_id' => 7],
            ['name' => 'business and industrial equipment', 'category_id' => 7],
            ['name' => 'construction services', 'category_id' => 7],

            ['name' => 'pets', 'category_id' => 8],
            ['name' => 'farm animals', 'category_id' => 8],
            ['name' => 'food for animals', 'category_id' => 8],
            ['name' => 'accessories for animals', 'category_id' => 8],
            ['name' => 'caretakers, pet sitters and dog walkers', 'category_id' => 8],
            ['name' => 'veterinary services', 'category_id' => 8],
            ['name' => 'grooming services', 'category_id' => 8],
            ['name' => 'other pets and animals', 'category_id' => 8],

            ['name' => 'furniture', 'category_id' => 9],
            ['name' => 'home appliances', 'category_id' => 9],
            ['name' => 'electricity, garden, air conditioner, bathroom', 'category_id' => 9],
            ['name' => 'other home items', 'category_id' => 9],

            ['name' => 'houses', 'category_id' => 10],
            ['name' => 'apartment', 'category_id' => 10],
            ['name' => 'rooms', 'category_id' => 10],
            ['name' => 'land', 'category_id' => 10],
            ['name' => 'commercial property', 'category_id' => 10],

            ['name' => 'toys and games', 'category_id' => 11],
            ['name' => 'books, cds, dvds', 'category_id' => 11],
        ];
    }
}
