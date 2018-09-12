import ProfileView from '../../pages/user/profile/View.vue';
import ProfileUpdate from '../../pages/user/profile/Form.vue';

import ScheduleManager from '../../pages/user/schedule/Manager.vue';

export default [
    {
        path: '/user/profile/view',
        component: ProfileView,
        name: 'userProfileView'
    },
    {
        path: '/user/profile/update',
        component: ProfileUpdate,
        name: 'userProfileUpdate',
        meta: {
            title: 'Редактирование профиля',
            breadcrumbs(route) {
                return [
                    {label: 'Профиль', to: {name: 'userProfileView'}},
                ];
            }
        },
    },
    {
        path: '/user/schedule',
        component: ScheduleManager,
        name: 'userScheduleManager',
        meta: {
            title: 'График работы',
            breadcrumbs(route) {
                return [
                    {label: 'График работы'},
                ];
            }
        },
    },
];