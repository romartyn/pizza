<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('shop.index');
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
