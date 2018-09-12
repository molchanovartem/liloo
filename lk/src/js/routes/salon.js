import SalonManager from '../../pages/salon/Manager.vue';
import SalonForm from '../../pages/salon/Form.vue';

import Appointment from '../../pages/salon/appointment/Appointment.vue';

import ServiceManager from '../../pages/salon/service/Manager.vue';

import MasterManager from '../../pages/salon/master/Manager.vue';
import MasterServiceManager from '../../pages/salon/master/service/Manager.vue';
import MasterScheduleList from '../../pages/salon/master/schedule/List.vue';
import MasterScheduleManager from '../../pages/salon/master/schedule/Manager.vue';

export default [
    {
        path: '/salon/manager',
        component: SalonManager,
        name: 'salonManager',
        meta: {
            title: 'Салоны',
            breadcrumbs: [
                {label: 'Салоны'}
            ]
        }
    },
    {
        path: '/salon/create',
        component: SalonForm,
        name: 'salonCreate',
        meta: {
            title: 'Создание салона',
            breadcrumbs: [
                {label: 'Салоны', to: {name: 'salonManager'}}
            ]
        },
        props: {type: 'create'}
    },
    {
        path: '/salon/update/:id',
        component: SalonForm,
        name: 'salonUpdate',
        meta: {
            title: 'Редактирование салона',
            breadcrumbs: [
                {label: 'Салоны', to: {name: 'salonManager'}}
            ]
        },
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
        meta: {
            title: 'Услуги',
            breadcrumbs(route) {
                return [
                    {label: 'Салоны', to: {name: 'salonManager'}},
                    {label: 'Услуги'}
                ];
            }
        },
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
        meta: {
            title: 'Мастера',
            breadcrumbs(route) {
                return [
                    {label: 'Салоны', to: {name: 'salonManager'}},
                    {label: 'Мастера'}
                ];
            }
        },
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
        meta: {
            title: 'Услуги мастера',
            breadcrumbs(route) {
                return [
                    {label: 'Салоны', to: {name: 'salonManager'}},
                    {label: 'Мастера', to: {name: 'salonMasterManager', params: {id: route.params.id}}},
                    {label: 'Услуги мастера'}
                ];
            }
        },
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
        meta: {
            title: 'График работы мастеров',
            breadcrumbs(route) {
                return [
                    {label: 'Салоны', to: {name: 'salonManager'}},
                    {label: 'График работы мастеров'}
                ];
            }
        },
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
        meta: {
            title: 'График работы мастера',
            breadcrumbs(route) {
                return [
                    {label: 'Салоны', to: {name: 'salonManager'}},
                    {label: 'График работы мастеров', to: {name: 'masterScheduleList', params: {id: route.params.id}}},
                    {label: 'График работы мастера'}
                ];
            }
        },
        props(route) {
            return {
                salonId: route.params.id,
                masterId: route.params.masterId
            }
        },
    },

    {
        path: '/salon/:id/appointment',
        name: 'salonAppointment',
        component: Appointment,
        meta: {
            title: 'Записи',
            breadcrumbs(route) {
                return [
                    {label: 'Салоны', to: {name: 'salonManager'}},
                    {label: 'Записи'}
                ];
            }
        },
        props(route) {
            return {
                salonId: route.params.id,
                userId: route.query.user_id
            };
        }
    }
];