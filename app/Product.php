<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public function scopeDefault($query)
	{
		return $query
				->where('base_price', '>', 0)
				->whereNotNull('unit_price')
				->with(['images','categories']);
	}

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function categories()
    {
        return $this->hasMany('App\ProductCategory');
    }
}
