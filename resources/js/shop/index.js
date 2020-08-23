import Vue from 'vue';
import {store} from './store/store.js';
import App from "./App.vue";
import HeadCart from "./components/HeadCart.vue";
import Helpers from "./mixins/Helpers";
import { BootstrapVue } from 'bootstrap-vue';

// import VueMask from 'v-mask';
import { VueMaskDirective } from 'v-mask';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);
// Vue.use(VueMask);
Vue.use(BootstrapVue);
Vue.directive('mask', VueMaskDirective);
Vue.mixin(Helpers);

let application = new Vue({
    render: h => h(App), store
});

let shop_div = document.getElementById('shop');

if(shop_div){
	application.$mount("#shop");
} else {
	new Vue({
	    render: h => h(HeadCart), store
	}).$mount("#head_cart");
}
