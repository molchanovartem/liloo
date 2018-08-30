import MasterManager from '../../pages/master/Manager.vue';
import MasterForm from '../../pages/master/Form.vue';

export default [
    {
        path: '/master/manager',
        name: 'masterManager',
        component: MasterManager
    },
    {
        path: '/master/create',
        name: 'masterCreate',
        component: MasterForm,
        props: {type: 'create'}
    },
    {
        path: '/master/update/:id',
        name: 'masterUpdate',
        component: MasterForm,
        props(route) {
            return {
                type: 'update',
                id: route.params.id
            }
        }
    },
];