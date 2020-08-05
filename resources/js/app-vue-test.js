import Vue from 'vue';
import Vuex from 'vuex';
import dayjs from 'dayjs'
import 'dayjs/locale/ru'
import Datepicker from 'vuejs-datepicker';
import App from "./App.vue";

new Vue({
    render: h => h(App)//, store
}).$mount("#app");