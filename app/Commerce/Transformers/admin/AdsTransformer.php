<?php
/**
 * Created by PhpStorm.
 * User: guru
 * Date: 3/31/17
 * Time: 7:36 AM
 */

namespace Commerce\Transformers\Admin;


use App\Ad;
use App\Category;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AdsTransformer extends TransformerAbstract
{
    public function __construct()
    {
//        Carbon::setLocale(LaravelLocalization::getCurrentLocale());
    }

    public function transform(Ad $ad)
    {
        return [
            'id' => $ad->id,
            'code' => $ad->code,
            'uuid' => $ad->uuid,
            'title' => $ad->title,
            'date' => $this->get_date($ad),
            'author' => $ad->owner->name,
            'category' => $this->get_trans_category($ad->category),
            'status' => $ad->status
        ];
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

    private function get_date(Ad $ad)
    {
        if($ad->status == 'online'){
            return $ad->start_date;
        }
        return Carbon::parse($ad->updated_at)->toDateTimeString();
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