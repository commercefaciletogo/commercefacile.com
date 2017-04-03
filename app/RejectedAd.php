<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectedAd extends Model
{
    protected $fillable = ['ad_id', 'fields'];
}
