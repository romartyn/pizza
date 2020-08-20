import Vue from 'vue';
import {store} from './store/store.js';
import App from "./App.vue";
import Helpers from "./mixins/Helpers";

import VueMask from 'v-mask';
import { VueMaskDirective } from 'v-mask';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);
Vue.use(VueMask);
Vue.directive('mask', VueMaskDirective);
Vue.mixin(Helpers);

new Vue({
    render: h => h(App), store
}).$mount("#shop");