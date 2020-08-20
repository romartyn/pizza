<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function categories()
    {
        return $this->hasMany('App\ProductCategory');
    }
}
