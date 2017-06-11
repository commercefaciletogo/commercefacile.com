<?php
/**
 * Created by PhpStorm.
 * User: guru
 * Date: 4/3/17
 * Time: 7:57 AM
 */

namespace App\Commerce\Transformers;


use App\Ad;
use App\Category;
use App\User;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class AdTransformer extends TransformerAbstract
{
    /**
     * @var User
     */
    private $user;

    /**
     * AdTransformer constructor.
     * @param User $user
     */
    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    public function transform(Ad $ad)
    {
        return [
            'id' => $ad->id,
            'uuid' => $ad->uuid,
            'title' => ucfirst($ad->title),
            'category' => $this->get_trans_category($ad->category),
            'condition' => $ad->condition,
            'description' => ucfirst($ad->description),
            'images' => $this->getAdBigImages($ad->images),
            'price' => $ad->price,
            'negotiable' => $ad->negotiable == 1 ? true : false,
            'date' => ucfirst(Carbon::parse($ad->start_date)->diffForHumans()),
            'owner' => $this->get_ad_owner($ad),
            'reported' => $this->is_reported($ad),
            'favorite' => $this->is_favorite($ad)
        ];
    }

    private function get_trans_category(Category $category)
    {
        $cat = $category->translate();
        return [
            'id' => $cat->category_id,
            'uuid' => $cat->uuid,
            'name' => $cat->name,
            'slug' => $cat->slug,
            'parent' => $this->get_trans_category_parent($category)
        ];
    }

    private function getAdBigImages($images)
    {
        return collect($images)
            ->filter(function($image){
                return $image['size'] == 'big';
            })->map(function($image){
                return $image['path'];
            })->sort()->all();
    }

    private function get_trans_category_parent(Category $category)
    {
        if(is_null($category->parent)) return null;
        $par = $category->parent->translate();
        return [
            'id' => $par->category_id,
            'uuid' => $par->uuid,
            'name' => $par->name,
            'slug' => $par->slug
        ];
    }

    private function get_ad_owner(Ad $ad)
    {
        $user = $ad->owner;
        return [
            'slug' => $user->slug,
            'name' => $user->name,
            'phone' => $user->phone,
            'location' => [
                'slug' => $user->location->slug,
                'uuid' => $user->location->uuid,
                'name' => $user->location->name
            ]
        ];
    }

    private function is_reported(Ad $ad)
    {
        if(is_null($this->user)) return false;
        return $ad->reporters->unique()->filter(function($user){
            return $user->id == $this->user->id;
        })->isNotEmpty();
    }

    private function is_favorite(Ad $ad)
    {
        if(is_null($this->user)) return false;
        return $ad->favoritors->unique()->filter(function($user){
            return $user->id == $this->user->id;
        })->isNotEmpty();
    }

}