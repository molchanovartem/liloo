import SalonManager from '../../pages/salon/Manager.vue';
import SalonForm from '../../pages/salon/Form.vue';

import Appointment from '../../pages/salon/appointment/Appointment.vue';

import ServiceManager from '../../pages/salon/service/Manager.vue';

import MasterManager from '../../pages/salon/master/Manager.vue';
import MasterServiceManager from '../../pages/salon/master/service/Manager.vue';
import MasterScheduleList from '../../pages/salon/master/schedule/List.vue';
import MasterScheduleManager from '../../pages/salon/master/schedule/MasterSchedule.vue';

export default [
    {
        path: '/salon/manager',
        component: SalonManager,
        name: 'salonManager',
        meta: {title: 'Салоны'}
    },
    {
        path: '/salon/create',
        component: SalonForm,
        name: 'salonCreate',
        meta: {title: 'Создание салона'},
        props: {type: 'create'}
    },
    {
        path: '/salon/update/:id',
        component: SalonForm,
        name: 'salonUpdate',
        meta: {title: 'Редактирование салона'},
        props(route) {
            return {
                type: 'update',
                id: route.params.id
            }
        }
    },

    // service
    {
        path: '/salon/:id/service',
        name: 'salonServiceManager',
        component: ServiceManager,
        props(route) {
            return {
                salonId: route.params.id
            };
        }
    },

    // master
    {
        path: '/salon/:id/master',
        name: 'salonMasterManager',
        component: MasterManager,
        props(route) {
            return {
                salonId: route.params.id
            };
        }
    },


    // masterService
    {
        path: '/salon/:id/master/:masterId/service',
        name: 'masterServiceManager',
        component: MasterServiceManager,
        props(route) {
            return {
                salonId: route.params.id,
                masterId: route.params.masterId
            }
        }
    },

    // masterSchedule
    {
        path: '/salon/:id/master/schedule',
        name: 'masterScheduleList',
        component: MasterScheduleList,
        props(route) {
            return {
                salonId: route.params.id,
            }
        },
    },
    {
        path: '/salon/:id/master/schedule/:masterId',
        name: 'masterScheduleManager',
        component: MasterScheduleManager,
        props(route) {
            return {
                salonId: route.params.id,
                masterId: route.params.master_id
            }
        },
    },

    {
        path: '/salon/:id/appointment',
        name: 'salonAppointment',
        component: Appointment,
        props(route) {
            return {
                salonId: route.params.id,
                userId: route.query.user_id
            };
        }
    }
];