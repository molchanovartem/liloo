import Vue from 'vue';
import Vuetify from 'vuetify';
import {router} from './router.js';
import {store} from './store.js';
import App from '../template/App.vue'
import {apolloProvider} from "./apolloProvider";

import VueGoodTable from 'vue-good-table';

Vue.use(Vuetify);
Vue.use(VueGoodTable);

new Vue({
    router, store,
    provide: apolloProvider.provide(),
    el: '#app',
    render: createElement => createElement(App)
});
