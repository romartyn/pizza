<template>
	<div class="row">
		<div class="col-md-4" v-for="product in pizzas.slice(0,9)">
			<div class="card mb-4 shadow-sm">
				<!-- <img
					class="bd-placeholder-img card-img-top"
					:src="product.images.length ? `/storage/${product.images[0].src}` : ''"
				> -->
				<div
					class="bd-placeholder-img card-img-top"
					:style="{
						background: `#fff url('${src(product)}') center center no-repeat`,
						'background-size': 'cover',
						'min-height': '200px'
					}"
				></div>
				<div class="card-body">
					<!-- <div class="card-text" v-html="product.description"></div> -->
					<div class="card-text" style="margin-bottom: 1em;">{{ product.title }}</div>
					<div class="d-flex justify-content-between align-items-center">
						<div class="btn-group">
							<button type="button" class="btn btn-success">Add to cart</button>
							<!-- <button type="button" class="btn btn-sm btn-secondary">Edit</button> -->
						</div>
						<strong class="text-primary" style="font-size: xx-large;line-height: 1;">{{ product.price }}</strong>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
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
				return this.$store.state.products.filter(p => p.title.toLowerCase().match('пицца'));
			}
		}
	}
</script>