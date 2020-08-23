import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

// const dayjs = require('dayjs');
// const isSameOrBefore = require('dayjs/plugin/isSameOrBefore');
// const weekOfYear = require('dayjs/plugin/weekOfYear');
// const isoWeek = require('dayjs/plugin/isoWeek');

// dayjs.extend(isoWeek)
// dayjs.extend(weekOfYear);
// dayjs.extend(isSameOrBefore);

Vue.use(Vuex);

axios.defaults.headers.common = {
	'X-Requested-With': 'XMLHttpRequest',
	'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute("content")
};

export const store = new Vuex.Store({
	state: {
		config: {
			default_delivery_item: {
				title: 'Стандартная доставка',
				price: 300
			},
			default_cart: {
				items: [],
				currencies: {
					ruble: { rate: 1, sign: '\u20BD' },
					dollar: { rate: 74.80, sign: '$' },
					euro: { rate: 88.20, sign: '\u20AC' }
				}
			}
		},
		currency: localStorage.getItem('currency') || 'dollar',
		checkout_show: true,
		order: null,
		cart: {
			items: [],
			currencies: {
				ruble: { rate: 1, sign: '\u20BD' },
				dollar: { rate: 74.80, sign: '$' },
				euro: { rate: 88.20, sign: '\u20AC' }
			}
		},
		products: [],
		categories: [],
	},
	mutations: {
		SET_CURRENCY:
			(state, data) => {
				state.currency = data;
				localStorage.setItem('currency', data);
			},
		SET_ORDER:
			(state, data) => {
				if(data.error){
					console.error(data);
					state.order = {
						error: data.error
					};
				} else {
					console.warn(data);
					state.order = data.order;
					state.cart = data.cart;
				}
			},
		SET_CART:
			(state, data) => {
				state.cart = data;
			},
		SET_PRODUCTS:
			(state, data) => {
				state.products = data;
			},
		SET_CATEGORIES:
			(state, data) => {
				state.categories = data;
			},
	},
	actions: {
		SET_CURRENCY: (context, data) => {
			context.commit('SET_CURRENCY', data);
		},
		ADD_TO_CART: (context, data) => {
			axios.post(`/shop/add-to-cart`, {
				_method: "POST",
				product_id: data.product.id,
				qnt: data.qnt
			}).then((response) => {
				context.commit('SET_CART', response.data);
			}).catch((error) => {
				console.log(error);
			});
		},
		STORE_ORDER: (context, data) => {
			axios.post(`/shop/store-order`, {
				_method: "POST",
				... data
			}).then((response) => {
				context.commit('SET_ORDER', response.data);
			}).catch((error) => {
				console.log(error);
			});
		},
		FETCH_CART: (context, data) => {
			axios.get('/shop/get-cart')
				.then(response => {
					context.commit('SET_CART', response.data);
				})
				.catch(error => {
					context.commit('SET_CART', context.state.config.default_cart);
				});
		},
		FETCH_PRODUCTS: (context, data) => {
			axios.post('/api/products', {
				_method: "POST",
				... data
			}).then(response => {
				context.commit('SET_PRODUCTS', response.data);
			})
			.catch(error => {
				context.commit('SET_PRODUCTS', []);
			});
		},
		FETCH_CATEGORIES: (context, data) => {
			axios.get('/api/categories')
				.then(response => {
					context.commit('SET_CATEGORIES', response.data);
				})
				.catch(error => {
					context.commit('SET_CATEGORIES', []);
				});
		},
	}
});