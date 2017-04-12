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

    protected $hidden = [
        'searchable',
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

    public function searchableOptions()
    {
        return [
            // You may wish to change the default name of the column
            // that holds parsed documents
//            'column' => 'indexable',
            // You may want to store the index outside of the Model table
            // In that case let the engine know by setting this parameter to true.
            'external' => true,
            // If you don't want scout to maintain the index for you
            // You can turn it off either for a Model or globally
            'maintain_index' => true,
            // Ranking groups that will be assigned to fields
            // when document is being parsed.
            // Available groups: A, B, C and D.
            'rank' => [
                'fields' => [
                    'title' => 'A',
                    'description' => 'B'
                ],
                // Ranking weights for searches.
                // [D-weight, C-weight, B-weight, A-weight].
                // Default [0.1, 0.2, 0.4, 1.0].
                'weights' => [0.1, 0.2, 0.4, 1.0],
                // Ranking function [ts_rank | ts_rank_cd]. Default ts_rank.
                'function' => 'ts_rank_cd',
                // Normalization index. Default 0.
                'normalization' => 32,
            ],
            // You can explicitly specify a PostgreSQL text search configuration for the model.
            // Use \dF in psql to see all available configurationsin your database.
            'config' => 'simple',
        ];
    }

    public function favoritors()
    {
        return $this->belongsToMany(User::class, 'favorite_ads', 'ad_id', 'user_id')->withTimestamps();
    }

    public function reporters()
    {
        return $this->belongsToMany(User::class, 'reported_ads', 'ad_id', 'user_id')->withTimestamps();
    }
}
