import Manager from '../../pages/service/Manager.vue';
import Form from '../../pages/service/Form.vue';

export default [
    {
        path: '/service',
        component: Manager,
        name: 'serviceManager',
        meta: {
            title: 'Услуги',
            breadcrumbs(route) {
                return [
                    {label: 'Услуги', to: {name: 'serviceManager'}}
                ];
            }
        },
    },
    {
        path: '/service/create',
        component: Form,
        name: 'serviceCreate',
        props: {
            type: 'create'
        },
        meta: {
            title: 'Создание услуги',
            breadcrumbs(route) {
                return [
                    {label: 'Создание услуги', to: {name: 'serviceCreate'}}
                ];
            }
        },
    },
    {
        path: '/service/update/:id',
        component: Form,
        name: 'serviceUpdate',
        props(route) {
            return {
                type: 'update',
                id: route.params.id
            }
        },
        meta: {
            title: 'Редактирование услуги',
            breadcrumbs(route) {
                return [
                    {label: 'Редактирование услуги', to: {name: 'serviceUpdate'}}
                ];
            }
        },
    }
];