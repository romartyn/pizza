<template>
	<div class="head-cart">
		<div class="head-cart-inner" v-if="empty" @click="toggleCheckoutShow">
			<div class="head-cart-caption btn btn-warning">Cart is empty</div>			
		</div>
		<div class="head-cart-inner" v-else @click="toggleCheckoutShow">
			<div class="head-cart-qnt btn btn-success">Cart contains {{ this.cart.items.length }} items ({{ qnt }} goods) </div>
			<div class="head-cart-cost btn btn-success">Cart items total: {{ $price_currency(cost) }}</div>
		</div>
		<div class="head-cart-inner currency-inner">
			<button
				class="btn btn-default currency-btn"
				@click="setCurrency('dollar')"
				:class="{active:currency == 'dollar'}"
			><i class="fas fa-dollar-sign"></i></button>
			<button
				class="btn btn-default currency-btn"
				@click="setCurrency('euro')"
				:class="{active:currency == 'euro'}"
			><i class="fas fa-euro-sign"></i></button>
			<button
				class="btn btn-default currency-btn"
				@click="setCurrency('ruble')"
				:class="{active:currency == 'ruble'}"
			><i class="fas fa-ruble-sign"></i></button>
		</div>
	</div>
</template>

<style module>
	.head-cart {
		display: flex;
		justify-content: center;
	}
	.head-cart-inner {
		display: flex;
	}
	.head-cart-qnt, .head-cart-cost, .head-cart-caption {
		margin: 0 .5em;
	}
	.currency-inner {
		/*min-width: 4.7rem;*/
		min-width: 7.5rem;
		justify-content: space-between;
	}
	.currency-btn {
		border: 1px solid #ccc;
	} .currency-btn.active {
		background: #ccc;
		color: teal;
	}
</style>

<script>
	export default {
		computed: {
			empty: function () {
				return this.cart.items.length == 0;
			},
			qnt: function () {
				return this.cart.items.reduce((sum, item) => {
					return sum + item.qnt;
				}, 0);
			},
			cost: function () {
				return this.cart.items.reduce((sum, item) => {
					return sum + item.cost;
				}, 0);
			},
			cart: function () {
				return this.$store.state.cart;
			},
			currency: function () {
				return this.$store.state.currency;
			},
		},
		methods: {
			toggleCheckoutShow: function(){
				this.$store.state.checkout_show = !this.$store.state.checkout_show;
			},
			setCurrency: function(currency){
				this.$store.dispatch('SET_CURRENCY', currency);
			}
		},
		created: function(){
			this.$store.commit("SET_PRODUCTS",products.slice(0,12));
			this.$store.commit("SET_CATEGORIES",categories);
			this.$store.commit("SET_CART",cart);
		}
	}
</script>