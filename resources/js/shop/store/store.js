import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

const dayjs = require('dayjs');
const isSameOrBefore = require('dayjs/plugin/isSameOrBefore');
const weekOfYear = require('dayjs/plugin/weekOfYear');
const isoWeek = require('dayjs/plugin/isoWeek');

dayjs.extend(isoWeek)
dayjs.extend(weekOfYear);
dayjs.extend(isSameOrBefore);

Vue.use(Vuex);

axios.defaults.headers.common = {
	'X-Requested-With': 'XMLHttpRequest',
	'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute("content")
};

export const store = new Vuex.Store({
	state: {
		products: [],
		categories: [],
	},
	mutations: {
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
		FETCH_PRODUCTS: (context, data) => {
            axios.get('/api/products')
                .then(response => {
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