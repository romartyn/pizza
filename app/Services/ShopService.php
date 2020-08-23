<?php

namespace App\Services;

class ShopService
{
	public const CURRENCIES = [
		'ruble' => [ 'rate' => 1, 'sign' => '₽' ],
		'dollar' => [ 'rate' => 74.80, 'sign' => '$' ],
		'euro' => [ 'rate' => 88.20, 'sign' => '€' ],
	];
	public static function getDefaultCart(){
		return (object)[
			'items' => [],
			'currencies' => self::CURRENCIES
		];
	}

	public static function get_cart()
	{
		$cart = session('cart');

		if(!$cart){
			$cart = self::getDefaultCart();
			session(['cart' => $cart]);
			session()->save();
		}

		return $cart;
	}
}