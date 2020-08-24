<template>
	<div class="row">
		<div class="col-md-4" v-for="product in products">
			<div class="card mb-4 shadow-sm product-card">
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
	.product-card:hover .background-description {
		opacity: 1;
	}
</style>

<script>
	import AddToCart from "./AddToCart";
	export default {
		components: {
			AddToCart
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
		}
	}
</script>