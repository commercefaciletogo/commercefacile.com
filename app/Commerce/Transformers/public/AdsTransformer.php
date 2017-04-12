<?php
/**
 * Created by PhpStorm.
 * User: guru
 * Date: 4/3/17
 * Time: 7:58 AM
 */

namespace App\Commerce\Transformers;


use App\Ad;
use App\Category;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class AdsTransformer extends TransformerAbstract
{

    public function transform(Ad $ad)
    {
        return [
            'id' => $ad->id,
            'uuid' => $ad->uuid,
            'category_id' => $ad->category_id,
            'title' => ucfirst($ad->title),
            'image' => $this->getAdSmallMainImage($ad->images),
            'price' => $ad->price,
            'owner' => $this->get_ad_owner($ad)
        ];
    }


    private function getAdSmallMainImage($images)
    {
        return collect($images)
            ->filter(function($image){
                return $image['size'] == 'small' && $image['main'] == 1;
            })->first()->path;
    }


    private function get_ad_owner(Ad $ad)
    {
        $user = $ad->owner;
        return [
            'id' => $user->id,
            'name' => $user->name,
            'location' => [
                'id' => $user->location->id,
            ]
        ];
    }

}