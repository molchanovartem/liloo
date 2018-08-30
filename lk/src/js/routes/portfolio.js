import PortfolioManager from '../../components/portfolio/PortfolioManager.vue';
import PortfolioForm from '../../components/portfolio/PortfolioForm.vue';
import PortfolioView from '../../components/portfolio/PortfolioView.vue';

export default [
    {
        path: '/portfolio/manager',
        component: PortfolioManager,
        name: 'portfolioManager',
        meta: {
            title: 'Порфолио'
        },
        props: (route) => ({
            salonId: route.query.salon_id
        })
    },
    {
        path: '/portfolio/view/:id',
        component: PortfolioView,
        name: 'portfolioView',
        meta: {
            title: 'Просмотр портфолио'
        }
    },
    {
        path: '/portfolio/create',
        component: PortfolioForm,
        name: 'portfolioCreate',
        meta: {
            title: 'Создание портфолио'
        },
        props: (route) => ({
            type: 'create',
            salonId: route.query.salon_id
        })
    },
    {
        path: '/portfolio/update/:id',
        component: PortfolioForm,
        name: 'portfolioUpdate',
        meta: {
            title: 'Редактирование портфолио'
        },
        props: {
            type: 'update'
        }
    },
];