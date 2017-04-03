<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdImage extends Model
{
    protected $fillable = ['ad_id', 'path', 'size', 'main', 'name'];
}
