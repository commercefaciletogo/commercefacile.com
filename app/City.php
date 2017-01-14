<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'slug', 'region_id'];

    public function region(){
        return $this->belongsTo(Region::class, 'region_id');
    }
}
