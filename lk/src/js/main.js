import Vue from 'vue';
import Vuetify from 'vuetify';
import {router} from './router.js';
import {store} from './store.js';
import {apolloProvider} from "./apolloProvider";
import Settings from './plugins/settings.js';
import App from '../template/App.vue';

Vue.use(Vuetify);
Vue.use(Settings);

new Vue({
    router, store,
    provide: apolloProvider.provide(),
    el: '#app',
    render: createElement => {
        return createElement(App);
    }
});
