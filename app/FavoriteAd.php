<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteAd extends Model
{
    protected $fillable = ['user_id', 'ad_id'];
}
