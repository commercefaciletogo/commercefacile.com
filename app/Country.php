<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name', 'slug'];

    public function regions(){
        return $this->hasMany(Region::class, 'region_id');
    }

    public function cities(){
        return $this->hasManyThrough(City::class, Region::class);
    }
}
