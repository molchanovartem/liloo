import TariffManager from '../../pages/tariff/Manager.vue';
import TariffList from '../../pages/tariff/List.vue';
import Checkout from '../../pages/tariff/Checkout.vue';

export default [
    {
        path: '/tariff/manager',
        name: 'tariffManager',
        component: TariffManager,
        meta: {
            title: 'Мои тарифы',
            breadcrumbs(route) {
                return [
                    {label: 'Мои тарифы'},
                ];
            }
        },
    },
    {
        path: '/tariff/list',
        name: 'tariffList',
        component: TariffList,
        meta: {
            title: 'Тарифы',
            breadcrumbs(route) {
                return [
                    {label: 'Тарифы'},
                ];
            }
        },
    },
    {
        path: '/tariff/checkout',
        name: 'tariffCheckout',
        component: Checkout,
        props(route) {
            return {
                tariffId: route.query.tariff_id,
                priceId: route.query.price_id
            }
        },
        meta: {
            title: 'Покупка тарифа',
            breadcrumbs(route) {
                return [
                    {label: 'Тарифы', to: {name: 'tariffList'}},
                    {label: 'Покупка тарифа'},
                ];
            }
        },
    },
];