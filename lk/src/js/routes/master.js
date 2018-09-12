import MasterManager from '../../pages/master/Manager.vue';
import MasterForm from '../../pages/master/Form.vue';

export default [
    {
        path: '/master/manager',
        name: 'masterManager',
        component: MasterManager,
        meta: {
            title: 'Мастера',
            breadcrumbs(route) {
                return [
                    {label: 'Мастера', to: {name: 'masterManager'}},
                ];
            }
        },
    },
    {
        path: '/master/create',
        name: 'masterCreate',
        component: MasterForm,
        meta: {
            title: 'Создание мастера',
            breadcrumbs(route) {
                return [
                    {label: 'Мастера', to: {name: 'masterManager'}},
                ];
            }
        },
        props: {type: 'create'}
    },
    {
        path: '/master/update/:id',
        name: 'masterUpdate',
        component: MasterForm,
        meta: {
            title: 'Редактирование мастера',
            breadcrumbs(route) {
                return [
                    {label: 'Мастера', to: {name: 'masterManager'}},
                ];
            }
        },
        props(route) {
            return {
                type: 'update',
                id: route.params.id
            }
        }
    },
];