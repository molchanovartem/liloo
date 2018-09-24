import BalanceIncrease from '../../pages/balance/Increase.vue';

export default [
    {
        path: '/balance/increase',
        name: 'balanceIncrease',
        component: BalanceIncrease,
        meta: {
            title: 'Пополнение баланса',
            breadcrumbs(route) {
                return [
                    {label: 'Баланс'},
                    {label: 'Пополнение баланса'},
                ];
            }
        },
    }
];