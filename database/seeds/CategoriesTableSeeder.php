<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Category;

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
        foreach ($this->get_data() as $data) {
            Category::create($data);
        }
        // DB::table('categories')->insert($this->get_data());
    }

    private function get_data(){
        return collect($this->get_categories())->map(function($key){
            $cat_en = trans("category.{$key}", [], "messages", "en");
            $cat_fr = trans("category.{$key}", [], "messages", "fr");
            
            return [
                'key' => $key,
                'en' => [
                    'name' => title_case($cat_en),
                    'slug' => str_slug($cat_en),
                    'key' => $key,
                ],
                'fr' => [
                    'name' => title_case($cat_fr),
                    'slug' => str_slug($cat_fr),
                    'key' => $key,
                ]
            ];
        })->toArray();
    }

    private function get_categories(){
        return [
            'electronics',
            'vehicles',
            'fashion_beauty',
            'education',
            'food_agric',
            'const_inds',
            'anim_pet',
            'home_fur_gar',
            'real_estate',
            'hobby_art',
            'other',
    //            'jobs_serv'
        ];
    }
}
