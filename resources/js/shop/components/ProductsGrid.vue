<template>
	<div class="row">
		<div class="col-md-4" v-for="product in pizzas.slice(0,9)">
			<div class="card mb-4 shadow-sm">
				<div
					class="bd-placeholder-img card-img-top product-description"
					:style="{
						background: `#fff url('${src(product)}') center center no-repeat`,
					}"
				>
					<div class="background-description" v-html="product.description"></div>
				</div>
				<div class="card-body">
					<div class="card-text" style="margin-bottom: 1em;">{{ product.title }}</div>
					<add-to-cart :product="product"></add-to-cart>
				</div>
			</div>
		</div>
	</div>
</template>

<style module>
	.product-description {
		background-size: cover !important;
		min-height: 200px;
		max-height: 200px;
		display: flex;
	}
	.background-description {
		opacity: 0;
		color: #fff;
		background-color: rgba(0,0,0,.5);
		padding: 2em;
		font-size: 18px;
		cursor: pointer;
		line-height: 100%;
	}
	.background-description:hover {
		opacity: 1;
	}
</style>

<script>
	import AddToCart from "./AddToCart";
	export default {
		components: {
			AddToCart
		},
		data: function() {
			return {
				//
			}
		},
		methods: {
			src: function(product){
				return product.images.length ? `/storage/${product.images[0].src}` : ''
			}
		},
		computed: {
			products: function () {
				return this.$store.state.products;
			},
			pizzas: function(){
				// return this.$store.state.products.filter(p => p.base_category == 2 && p.images.length > 0);
				return this.products.filter(p => p.title.toLowerCase().match('пицца'))/*.map(x => {
					console.log(x);
					return x;
				})*/;
			}
		}
	}
</script>