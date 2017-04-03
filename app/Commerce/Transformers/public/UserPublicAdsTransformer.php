<?php
/**
 * Created by PhpStorm.
 * User: guru
 * Date: 4/3/17
 * Time: 7:03 AM
 */

namespace App\Commerce\Transformers;


use App\Ad;
use App\Category;
use League\Fractal\TransformerAbstract;

class UserPublicAdsTransformer extends TransformerAbstract
{

    public function transform(Ad $ad)
    {
        return [
            'uuid' => $ad->uuid,
            'title' => ucfirst($ad->title),
            'category' => $this->get_trans_category($ad->category),
            'condition' => ucfirst($ad->condition),
            'description' => ucfirst(str_limit($ad->description, 25)),
            'image' => $this->getAdSmallMainImage($ad->images),
            'price' => $ad->price,
        ];
    }

    private function getAdSmallMainImage($images)
    {
        return collect($images)
            ->filter(function($image){
                return $image['size'] == 'small' && $image['main'] == 1;
            })->first()->path;
    }

    private function get_trans_category(Category $category)
    {
        $cat = $category->translate();
        return [
            'id' => $cat->category_id,
            'name' => $cat->name,
            'parent' => $this->get_trans_category_parent($category)
        ];
    }

    private function get_trans_category_parent(Category $category)
    {
        if(is_null($category->parent)) return null;
        $par = $category->parent->translate();
        return [
            'id' => $par->category_id,
            'name' => $par->name
        ];
    }
}