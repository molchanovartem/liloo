import MainLayout from '../template/layouts/Main.vue';
import Login from '../pages/Login.vue';

import balance from './routes/balance';
import tariff from './routes/tariff';
import appointment from './routes/appointment';
import client from './routes/client';
import portfolio from './routes/portfolio';
import review from './routes/review';
import salon from './routes/salon';
import service from './routes/service';
import serviceGroup from './routes/serviceGroup';
import user from './routes/user';
import master from './routes/master';

export const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '*',
        component: MainLayout,
    },
    {
        path: '/',
        component: MainLayout,
        name: 'home',
        children: [].concat(
            balance,
            tariff,
            appointment,
            client,
            portfolio,
            review,
            salon,
            service,
            serviceGroup,
            user,
            master
        )
    }
];