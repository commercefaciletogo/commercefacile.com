<?php
/**
 * Created by PhpStorm.
 * User: guru
 * Date: 3/31/17
 * Time: 4:42 PM
 */

namespace Commerce\Transformers\Admin;


use App\Ad;
use App\Category;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class AdTransformer extends TransformerAbstract
{

    public function transform(Ad $ad)
    {
        return [
            'id' => $ad->id,
            'code' => $ad->code,
            'uuid' => $ad->uuid,
            'title' => $ad->title,
            'condition' => $ad->condition,
            'description' => $ad->description,
            'price' => $ad->price,
            'negotiable' => $ad->negotiable,
            'date' => $this->get_date($ad),
            'author' => $ad->owner->name,
            'category' => $this->get_trans_category($ad->category),
            'status' => $ad->status,
            'images' => $ad->images->groupBy('size')->toArray()
        ];
    }

    private function get_trans_category(Category $category)
    {
        $cat = $category->translate();
        $par = $category->parent->translate();
        return [
            'id' => $cat->category_id,
            'name' => $cat->name,
            'parent' => [
                'id' => $par->category_id,
                'name' => $par->name
            ]
        ];
    }

    private function get_date(Ad $ad)
    {
        if($ad->status == 'online'){
            return $ad->start_date;
        }
        return Carbon::parse($ad->updated_at)->toDateTimeString();
    }

}