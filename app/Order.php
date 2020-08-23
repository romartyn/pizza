<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = [
		'user_id',
		'name',
		'email',
		'phone',
		'address',
		'currency',
		'total',
	];

	public function items()
	{
	    return $this->hasMany('App\OrderItem');
	}
}
