<template>
	<div class="checkout" v-if="show">
		<div class="checkout-form">
			<div class="row">
				<div class="col-md-4 order-md-2 mb-4">
					<h4 class="d-flex justify-content-between align-items-center mb-3">
						<span class="text-muted">Your cart</span>
						<span class="badge badge-secondary badge-pill">{{ qnt }}</span>
					</h4>
					<ul class="list-group mb-3">
						<li v-for="item in cart.items" class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">{{ item.title }}</h6>
								<small class="text-primary">{{ $price_currency(item.price) }} X {{ item.qnt }}</small>
							</div>
							<span class="text-muted text-nowrap">{{ $price_currency(item.cost) }}</span>
						</li>

						<li class="list-group-item d-flex justify-content-between">
							<span>Total</span>
							<strong>{{ $price_currency(cost) }}</strong>
						</li>

						<hr class="mb-4">
						<button class="btn btn-primary btn-lg btn-block" type="submit" @click="submit">Submit order</button>
						<hr class="mb-4">
						<button class="btn btn-warning btn-lg btn-block" type="submit" @click="toggleCheckoutShow">Keep on shopping</button>
					</ul>
				</div>
				<div class="col-md-8 order-md-1">
					<h4 class="mb-3">Fill in the form</h4>
					<form class="needs-validation needs-validation was-validated" novalidate="">
						
						<div class="mb-3">
							<label for="name">Contact name</label>
							<input v-model="form.name" type="text" class="form-control" id="name" placeholder="" value="" required :state="true">
							<div class="invalid-feedback">
								We need to know how to identify you.
							</div>
						</div>

						<div class="mb-3">
							<label for="phone">Phone</label>
							<div class="input-group">
								<b-form-input v-model="form.phone" required></b-form-input>

								<div class="invalid-feedback" style="width: 100%;">
									Your email is required, it's going to be used as login.
								</div>
							</div>
						</div>

						<div class="mb-3">
							<label for="email">Email</label>
							<input v-model="form.email" type="email" class="form-control" id="email" placeholder="you@example.com" required>
							<div class="invalid-feedback">
								Please enter a valid email address for shipping tracking and order history checking.
							</div>
						</div>

						<div class="mb-3">
							<label for="address">Address</label>
							<input v-model="form.address" type="text" class="form-control" id="address" placeholder="1234 Main St" required>
							<div class="invalid-feedback">
								Please enter your shipping address.
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<style module>
	.checkout {
		position: absolute;
		top: 0;
		width: 100%;
		height: 100%;
		background: rgba(0,0,0,.5);
		padding: 5em;
	}
	.checkout-form {
		background: rgba(255,255,255,.9);
		width: 100%;
		max-height: 100%;
		padding: 1em;
		overflow-y: scroll;
		overflow-x: hidden;
	}
</style>

<script>
	export default {
		data: {
			form: {
				name: null,
				phone: null,
				email: null,
				address: null,
			}
		},
		computed: {
			show: function () {
				return this.$store.state.checkout_show;
			},
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
			submit: function(){
				//
			},
			toggleCheckoutShow: function(){
				this.$store.state.checkout_show = !this.$store.state.checkout_show;
			},
		}
	}
</script>