import Manager from '../../pages/client/Manager.vue';
import Form from '../../pages/client/Form.vue';

export default [
    {
        path: '/client/manager',
        component: Manager,
        name: 'clientManager',
        meta: {title: 'Клиеты'},
    },
    {
        path: '/client/create',
        component: Form,
        name: 'clientCreate',
        meta: {title: 'Создание клиента'},
        props: {type: 'create'}
    },
    {
        path: '/client/update/:id',
        component: Form,
        name: 'clientUpdate',
        meta: {title: 'Редактирование клиента'},
        props(route) {
            return {
                type: 'update',
                id: route.params.id
            }
        }
    }
];