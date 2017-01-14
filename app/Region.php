<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'slug', 'country_id'];

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function cities(){
        return $this->hasMany(City::class, 'region_id');
    }
}
