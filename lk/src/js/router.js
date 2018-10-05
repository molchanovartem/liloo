import Vue from 'vue';
import VueRouter from 'vue-router';
import {routes} from './routes.js';

Vue.use(VueRouter);

export const router = new VueRouter({
    mode: 'history',
    routes: routes
});

// @todo рефакторинг
router.beforeEach((to, from, next) => {
    next(true);

    if (localStorage.getItem('authenticate') === 'false' && from.path !== '/login') {
        next({path: '/login'});
    } else {
        next(true);
    }
});