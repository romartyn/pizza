@extends('layouts.app')

@section('title', 'Pizza Order System')

@section('content')
	<div class="container">
		<div id="shop"></div>
	</div>
@endsection

@section('javascript')
	<script src="{{ mix('js/shop/index.js') }}"></script>
@endsection