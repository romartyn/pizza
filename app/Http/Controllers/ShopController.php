<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ShopController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('shop.index');
    }

    public static function getDefaultCart(){
        return (object)[
            'items' => [],
            'currencies' => [
                'ruble' => [ 'rate' => 1, 'sign' => '₽' ],
                'dollar' => [ 'rate' => 74.80, 'sign' => '$' ],
                'euro' => [ 'rate' => 88.20, 'sign' => '€' ],
            ]
        ];
    }

    public function get_cart(Request $request)
    {
        $cart = session('cart');

        if(!$cart){
            $cart = self::getDefaultCart();
            session(['cart' => $cart]);
            session()->save();
        }

        return response((array)$cart, 200);
    }
    public function add_to_cart(Request $request)
    {
        $data = $request->all();

        $product = Product::findOrFail( $data['product_id'] );

        $cart = session('cart', self::getDefaultCart());

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
        dd(
            $data,
            $cart,
            $request->session(),
            session('cart'),
        );
    }

    public function products()
    {
        return response(\App\Product::query()->with(['images','categories'])->get(), 200);
    }

    public function categories()
    {
        return response(\App\Category::query()->get(), 200);
    }
}
