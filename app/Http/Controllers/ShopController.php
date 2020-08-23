<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShopService;
use App\Product;
use App\Category;
use App\Order;
use App\OrderItem;
use App\User;

use Illuminate\Support\Collection;

class ShopController extends Controller
{
	public function __construct()
	{
		//$this->middleware('auth');
	}

	public function index()
	{
		return view('shop.index');
	}

	public function get_cart(Request $request)
	{
		$cart = ShopService::get_cart();

		return response((array)$cart, 200);
	}

	public function orders(Request $request)
	{
		$user = \Request::user();
		$orders = Order::query()->where('user_id', $user->id)->with('items')->get();
		return view('shop.orders',['orders' => $orders]);
	}
	public function store_order(Request $request)
	{
		$data = $request->all();
		$cart = ShopService::get_cart();

		$user = \Request::user();
		if(!$user){
			$user_by_email = User::query()->where('email', $data['email'])->first();
			if($user_by_email){
				return response([
					'error' => 'A user with such Email exists, please perform login first'
				], 200);
			}
			$user = User::create([
				'name' => $data['name'],
				'email' => $data['email'],
				'password' => '',
				'role' => 'client',
			]);
		}

		$items = collect($cart->items);
		$total_rub = $items->reduce(function ($carry, $item) {
			return $carry + $item->cost;
		});
		$total = round($total_rub / $cart->currencies[ $data['currency'] ]['rate'], 2);

		// Order::truncate();
		// OrderItem::truncate();
		$order = Order::create([
			'user_id' => $user->id,
			'name' => $data['name'],
			'email' => $data['email'],
			'phone' => $data['phone'],
			'address' => $data['address'],
			'currency' => $data['currency'],
			'total' => $total
		]);

		foreach ($items as $key => $item) {
			$order_item = OrderItem::create([
				'order_id' => $order->id,
				'product_id' => $item->product_id,
				'qnt' => $item->qnt,
				'price' => round($item->price / $cart->currencies[ $data['currency'] ]['rate'], 2),
				'cost' => round($item->cost / $cart->currencies[ $data['currency'] ]['rate'], 2),
				'currency' => $data['currency'],
			]);
		}

		$order->load('items');
		$order->items->map(function($item){
            return $item->load('product');
        });

		// \App\Services\MailService::sendOrder($order);

		$cart = ShopService::getDefaultCart();
		session(['cart' => $cart]);

		return response([
			'order' => $order,
			'cart' => $cart,
		], 200);
	}

	public function add_to_cart(Request $request)
	{
		$data = $request->all();

		$product = Product::findOrFail( $data['product_id'] );

		$cart = session('cart', ShopService::getDefaultCart());

		$index = -1;
		foreach ($cart->items as $key => $item) {
			if($item->product_id == $product->id){
				$index = $key;
				break;
			}
		}

		if($index >= 0){
			$cart->items[ $index ]->qnt += $data['qnt'];
			$cart->items[ $index ]->cost =
				$cart->items[ $index ]->qnt * $cart->items[ $index ]->price;

			if($cart->items[ $index ]->qnt <= 0){
				unset($cart->items[ $index ]);
				$cart->items = array_values($cart->items);
			}
		} else {
			$cart->items[] = (object)[
				'title' => $product->title,
				'product_id' => $product->id,
				'qnt' => $data['qnt'],
				'price' => $product->base_price,
				'cost' => $product->base_price * $data['qnt']
			];
		}

		session(['cart' => $cart]);
		session()->save();

		return response((array)$cart, 200);
	}

	public function products(Request $request)
	{
		$data = $request->all();

		$products_query = Product::query()->default();

		if(isset($data['match']) AND !empty($data['match'])){
			$products_query->whereRaw("LOWER(title) REGEXP '{$data['match']}'");
		}

		$products = $products_query->get();
		return response($products, 200);
	}

	public function categories()
	{
		return response(Category::query()->get(), 200);
	}
}
