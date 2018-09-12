import DashBoard from '../../components/Dashboard';

export default [
    {
        path: '*',
        component: DashBoard,
    },
    {
        path: '/',
        component: DashBoard,
        name: 'home'
    },
];