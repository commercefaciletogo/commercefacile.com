<?php
/**
 * Created by PhpStorm.
 * User: guru
 * Date: 4/2/17
 * Time: 9:44 PM
 */

namespace App\Commerce\Transformers;


use App\Ad;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ProfileAdTransformer extends TransformerAbstract
{

    public function transform(Ad $ad)
    {
        return [
            'id' => $ad->id,
            'uuid' => $ad->uuid,
            'code' => $ad->code,
            'status' => $ad->status,
            'title' => ucfirst($ad->title),
            'main_category' => $this->getTranslatedAdMainCategory($ad->category),
            'category' => $this->getTranslatedAdCategory($ad->category),
            'condition' => ucfirst($ad->condition),
            'description' => ucfirst(str_limit($ad->description, 25)),
            'image' => $this->getAdSmallMainImage($ad->images),
            'price' => $ad->price,
            'start_date' => Carbon::parse($ad->updated_at)->toFormattedDateString(),
            'end_date' => ''
        ];
    }

    private function getTranslatedAdMainCategory($category)
    {
        if(is_null($category['parent_id'])) return $this->getTranslatedAdCategory($category);

        return $category->parent->translate();
    }

    private function getTranslatedAdCategory($category)
    {
        return $category->translate();
    }

    private function getAdSmallMainImage($images)
    {
        return collect($images)
            ->filter(function($image){
                return $image['size'] == 'small' && $image['main'] == 1;
            })->first()->path;
    }

}