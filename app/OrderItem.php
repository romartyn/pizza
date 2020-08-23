<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
	protected $fillable = [
		'order_id',
		'product_id',
		'qnt',
		'price',
		'cost',
		'currency',
	];

	public function product()
	{
	    return $this->belongsTo(Product::class);
	}
}
