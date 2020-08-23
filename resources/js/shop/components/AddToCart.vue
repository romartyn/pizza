<template>
	<div class="d-flex justify-content-between align-items-center">
		<div class="btn-group">
			<button
				v-if="this.index >= 0"
				type="button"
				class="btn btn-success"
				@click="add"
			>+</button>
			<button
				type="button"
				class="btn" :class="[{'btn-success': this.index < 0},{'btn-warning': this.index >= 0}]"
				@click="toggle"
			>
				<i class="fas fa-cart-plus"></i> {{ to_cart_text }}</button>
		</div>
		<strong class="text-primary" style="font-size: xx-large;line-height: 1;">{{ $price_currency(product.base_price) }}</strong>
	</div>
</template>

<script>
	export default {
		props: {
			product: Object,
		},
		computed: {
			to_cart_text: function(){
				return this.index >= 0 ? 'Убрать' : 'В корзину'
			},
			index: function(){
				return this.$store.state.cart.items.findIndex(
					item =>
						item.product_id == this.product.id
				)
			},
		},
		methods: {
			add: function() {
				this.$store.dispatch('ADD_TO_CART', {
					product: this.product,
					qnt: 1
				});
			},
			toggle: function() {
				this.$store.dispatch('ADD_TO_CART', {
					product: this.product,
					qnt: this.index >= 0 ? -( this.$store.state.cart.items[this.index].qnt ) : 1
				});
			},
		}
	}
</script>