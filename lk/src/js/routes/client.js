import Manager from '../../pages/client/Manager.vue';
import Form from '../../pages/client/Form.vue';

export default [
    {
        path: '/client/manager',
        component: Manager,
        name: 'clientManager',
        meta: {
            title: 'Клиеты',
            breadcrumbs(route) {
                return [
                    {label: 'Клиеты'},
                ];
            }
        },
    },
    {
        path: '/client/create',
        component: Form,
        name: 'clientCreate',
        meta: {
            title: 'Создание клиента',
            breadcrumbs(route) {
                return [
                    {label: 'Клиеты', to: {name: 'clientManager'}},
                ];
            }
        },
        props: {type: 'create'}
    },
    {
        path: '/client/update/:id',
        component: Form,
        name: 'clientUpdate',
        meta: {
            title: 'Редактирование клиента',
            breadcrumbs(route) {
                return [
                    {label: 'Клиеты', to: {name: 'clientManager'}},
                ];
            }
        },
        props(route) {
            return {
                type: 'update',
                id: route.params.id
            }
        }
    }
];