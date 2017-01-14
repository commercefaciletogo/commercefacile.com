<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'slug'];

    public function sub_categories(){
        return $this->hasMany(SubCategory::class, 'category_id');
    }
}
