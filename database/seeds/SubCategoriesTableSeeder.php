<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Category;

class SubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->get_data() as $data) {
            Category::create($data);
        }
        // DB::table('categories')->insert($this->get_data());
    }

    private function get_data(){
        return collect($this->get_sub_categories())->map(function($s_c){
            $sub_cat_en = trans("category.{$s_c['key']}", [], "messages", "en");
            $sub_cat_fr = trans("category.{$s_c['key']}", [], "messages", "fr");

            return [
                'parent_id' => $s_c['category_id'],
                'key' => $s_c['key'],
                'en' => [
                    'name' => title_case($sub_cat_en),
                    'slug' => str_slug($sub_cat_en),
                    'key' => $s_c['key'],
                    'parent_id' => $s_c['category_id'],
                ],
                'fr' => [
                    'name' => title_case($sub_cat_fr),
                    'slug' => str_slug($sub_cat_fr),
                    'key' => $s_c['key'],
                    'parent_id' => $s_c['category_id'],
                ]
            ];
        })->toArray();
    }

    private function get_sub_categories(){
        return [
            ['key' => 'mob_pho', 'category_id' => 1],
            ['key' => 'mob_pho_acc', 'category_id' => 1],
            ['key' => 'comp_tab', 'category_id' => 1],
            ['key' => 'comp_acc', 'category_id' => 1],
            ['key' => 'tvs', 'category_id' => 1],
            ['key' => 'tv_video', 'category_id' => 1],
            ['key' => 'cam', 'category_id' => 1],
            ['key' => 'audio_mp3', 'category_id' => 1],
            ['key' => 'other_elec', 'category_id' => 1],

            ['key' => 'car_acc', 'category_id' => 2],
            ['key' => 'cars', 'category_id' => 2],
            ['key' => 'moto', 'category_id' => 2],
            ['key' => 'other_veh', 'category_id' => 2],
            ['key' => 'bicy', 'category_id' => 2],

//            ['key' => 'off_job', 'category_id' => 3],
//            ['key' => 'seek_job', 'category_id' => 3],
//            ['key' => 'serv', 'category_id' => 3],

            ['key' => 'clot_sho', 'category_id' => 3],
            ['key' => 'heal_beau', 'category_id' => 3],
            ['key' => 'watch_jew', 'category_id' => 3],
            ['key' => 'other_pers_item', 'category_id' => 3],

            ['key' => 'textb', 'category_id' => 4],
            ['key' => 'teach_train', 'category_id' => 4],
            ['key' => 'other_educ', 'category_id' => 4],

            ['key' => 'food', 'category_id' => 5],
            ['key' => 'crop_seed', 'category_id' => 5],
            ['key' => 'chem_tool', 'category_id' => 5],
            ['key' => 'other_food', 'category_id' => 5],

            ['key' => 'const_tool', 'category_id' => 6],
            ['key' => 'const_build', 'category_id' => 6],
            ['key' => 'busi_indus', 'category_id' => 6],
            ['key' => 'const_serv', 'category_id' => 6],

            ['key' => 'pets', 'category_id' => 7],
            ['key' => 'farm_anim', 'category_id' => 7],
            ['key' => 'food_anim', 'category_id' => 7],
            ['key' => 'acc_anim', 'category_id' => 7],
            ['key' => 'care_pet', 'category_id' => 7],
            ['key' => 'verte_serv', 'category_id' => 7],
            ['key' => 'groom_serv', 'category_id' => 7],
            ['key' => 'other_pets', 'category_id' => 7],

            ['key' => 'furni', 'category_id' => 8],
            ['key' => 'home_appl', 'category_id' => 8],
            ['key' => 'elec_gard', 'category_id' => 8],
            ['key' => 'other_home_item', 'category_id' => 8],

            ['key' => 'houses', 'category_id' => 9],
            ['key' => 'apart', 'category_id' => 9],
            ['key' => 'rooms', 'category_id' => 9],
            ['key' => 'land', 'category_id' => 9],
            ['key' => 'comm_prop', 'category_id' => 9],

            ['key' => 'toys_games', 'category_id' => 10],
            ['key' => 'books_cds', 'category_id' => 10],
        ];
    }
}
