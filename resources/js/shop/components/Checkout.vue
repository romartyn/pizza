<template>
	<div class="checkout" v-if="show">
		<form v-if="this.cart.items.length > 0" class="checkout-form was-validated" novalidate><!-- needs-validation -->
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
						<button class="btn btn-primary btn-lg btn-block" @click.stop.prevent="submit">Submit order</button>
						<hr class="mb-4">
						<button class="btn btn-warning btn-lg btn-block" @click.stop.prevent="toggleCheckoutShow">Keep on shopping</button>
					</ul>
				</div>
				<div class="col-md-8 order-md-1">
					<h4 class="mb-3">Fill in the form</h4>
					<!-- <form class="needs-validation needs-validation was-validated" novalidate=""> -->
						
						<div class="mb-3">
							<label for="name">Contact name</label>
							<input
								v-model="form.name"
								type="text"
								class="form-control"
								id="name"
								required
								:state="validate('name')"
							>
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
							<b-form-input v-model="form.email" type="email" required id="email"></b-form-input>
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
					<!-- </form> -->
				</div>
			</div>
		</form>
		<template v-else>
			<div v-if="order" class="checkout-form">
				<h1 class="text-center">Order #{{ order.id }} successfully sent</h1>
				<div class="row">
					<div class="col-md-3">
						<strong>Name</strong>
						<br>{{ order.name }}</div>
					<div class="col-md-3">
						<strong>Email</strong>
						<br>{{ order.email }}</div>
					<div class="col-md-3">
						<strong>Phone</strong>
						<br>{{ order.phone }}</div>
					<div class="col-md-3">
						<strong>Address</strong>
						<br>{{ order.address }}</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<strong>Total</strong><br>{{ config.default_cart.currencies[ order.currency ].sign }} {{ order.total }}</div>
				</div>
				<div class="row">
					<div class="col-md-12" v-for="item in order.items">
						<div style="font-weight: bold;">{{ item.product.title }}</div>
						<div v-html="item.product.short_description"></div>
						<div>Quantity: {{ config.default_cart.currencies[ order.currency ].sign }} {{ item.qnt }}</div>
						<div>Price: {{ config.default_cart.currencies[ order.currency ].sign }} {{ item.price }}</div>
						<div>Cost: {{ config.default_cart.currencies[ order.currency ].sign }} {{ item.cost }}</div>
						<hr class="mb-4">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button
							class="btn btn-warning btn-lg btn-block"
							@click.stop.prevent="toggleCheckoutShow(true)">Shop again!</button>
					</div>
				</div>
			</div>
			<div v-else class="checkout-form" style="padding: 10% 1em;">
				<h1 class="text-center">Your cart is empty and no order can be sent</h1>
				<button
					class="btn btn-warning btn-lg btn-block"
					@click.stop.prevent="toggleCheckoutShow">Go shopping!</button>
			</div>
		</template>
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
		data: function(){
			return {
				form: {
					name: null,
					phone: null,
					email: null,
					address: null,
				}
			};
		},
		watch: {
			order: function(new_value, old_value){	console.log(new_value);
				if(new_value.error){
					this.$swal(new_value.error, '', 'error');
				}
			}
		},
		computed: {
			order: function () {
				return this.$store.state.order;
			},
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
			config: function() {
				return this.$store.state.config;
			}
		},
		methods: {
			validate: function(name){
				switch (name) {
					case 'name':
						return this.form.name !== null && this.form.name.length > 3;
					case 'phone':
						return this.form.phone !== null && this.form.phone.length > 3;
					case 'address':
						return this.form.address !== null && this.form.address.length > 3;
					case 'email':
						return this.form.phone !== null && this.form.phone.length > 3;
				}
			},
			submit: function(){
				for(let [key, value] of Object.entries(this.form)){
					if(!this.validate(key)){
						this.$swal('Please fill in the form properly!', '', 'error');
						return;
					}
				}

				this.$store.dispatch('STORE_ORDER', {
					... this.form,
					currency: this.currency
				});
			},
			toggleCheckoutShow: function(again){
				this.$store.state.checkout_show = !this.$store.state.checkout_show;
			},
		}
	}
</script>