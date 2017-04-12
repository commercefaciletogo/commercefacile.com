<?php
/**
 * Created by PhpStorm.
 * User: guru
 * Date: 4/2/17
 * Time: 9:48 PM
 */

namespace App\Commerce\Transformers;


use App\Ad;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ProfileAdsTransformer extends TransformerAbstract
{

    /**
     * @param Ad $ad
     * @return array
     */
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
            'image' => $ad->images->isNotEmpty() ? $this->getAdSmallMainImage($ad->images) : '/img/icons/loading.gif',
            'price' => $ad->price,
            'start_date' => $this->get_start_date($ad),
            'end_date' => $this->get_end_date($ad),
            'rejected_fields' => $this->get_rejected_fields($ad),
            'editable' => $ad->images->isNotEmpty()
        ];
    }

    /**
     * @param $category
     * @return mixed
     */
    private function getTranslatedAdMainCategory($category)
    {
        if(is_null($category['parent_id'])) return $this->getTranslatedAdCategory($category);

        return $category->parent->translate();
    }

    /**
     * @param $category
     * @return mixed
     */
    private function getTranslatedAdCategory($category)
    {
        return $category->translate();
    }

    /**
     * @param $images
     * @return mixed
     */
    private function getAdSmallMainImage($images)
    {
        return collect($images)
            ->filter(function($image){
                return $image['size'] == 'small' && $image['main'] == 1;
            })->first()->path;
    }

    /**
     * @param Ad $ad
     * @return string
     */
    private function get_start_date(Ad $ad)
    {
        if($ad['status'] == 'pending') return Carbon::parse($ad->updated_at)->toFormattedDateString();
        return Carbon::parse($ad->start_date)->toFormattedDateString();
    }

    /**
     * @param Ad $ad
     * @return null|string
     */
    private function get_end_date(Ad $ad)
    {
        if($ad['status'] == 'pending') return null;
        return Carbon::parse($ad->end_date)->toFormattedDateString();
    }

    /**
     * @param Ad $ad
     * @return array|null
     */
    private function get_rejected_fields(Ad $ad)
    {
        if($ad['status'] != 'rejected') return null;
        $translated_fields = collect(explode(".", $ad->rejected->fields))
            ->map(function($field){
                return trans("general.ad_{$field}");
            })->toArray();
        return implode(', ', $translated_fields);
    }

}