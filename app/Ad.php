<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Ad extends Model
{

    use Searchable;

    protected $fillable = [
        'uuid',
        'code',
        'title',
        'condition',
        'description',
        'price',
        'negotiable',
        'category_id',
        'user_id',
        'status',
        'start_date',
        'end_date'
    ];

//    public function toSearchableArray()
//    {
//        $array = $this->toArray();
//
//        return $array;
//    }

    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images(){
        return $this->hasMany(AdImage::class, 'ad_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function rejected()
    {
        return $this->hasOne(RejectedAd::class, 'ad_id');
    }
}
