@extends('layouts.app')

@section('title', 'Pizza Order System')

@section('content')
	<div class="container">
		<div id="shop" class="shop-loading"></div>
	</div>
@endsection

@section('javascript')
	<script>
		let products = @json(\App\Product::query()->default()->get());
		let categories = @json(\App\Category::query()->get());
		let cart = @json(\App\Services\ShopService::get_cart());
	</script>

	<script src="{{ mix('js/shop/index.js') }}"></script>

	<style>
		.shop-loading {
			background: url('/assets/pizza-loading.gif');
			width: 100%;
			min-height: 100vh;
			background-repeat: no-repeat;
			background-position: center 40%;
		}
	</style>
@endsection