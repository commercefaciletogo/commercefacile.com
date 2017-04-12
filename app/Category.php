<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Dimsav\Translatable\Translatable;

class Category extends Model
{
    use Translatable;

    public $translatedAttributes = ['name, slug'];
    protected $table = 'categories';

    protected $fillable = ['parent_id', 'uuid'];

    public function ads()
    {
        return $this->hasMany(Ad::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function sub_categories(){
        return $this->hasMany(SubCategory::class, 'category_id');
    }
}
