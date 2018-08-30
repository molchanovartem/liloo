
import ServiceGroupManager from '../../pages/serviceGroup/ServiceGroupManager.vue';
import ServiceGroupForm from '../../pages/serviceGroup/ServiceGroupForm.vue';

export default [
    {
        name: 'serviceGroupManager',
        path: '/service/group',
        component: ServiceGroupManager,
    },
    {
        name: 'serviceGroupCreate',
        path: '/service/group/create',
        component: ServiceGroupForm,
        props: {
            type: 'create'
        }
    },
    {
        name: 'serviceGroupUpdate',
        path: '/service/group/update/:id',
        component: ServiceGroupForm,
        props(route) {
            return {
                type: 'update',
                id: route.params.id
            }
        },
    }
];