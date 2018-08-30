import ProfileView from '../../pages/user/profile/View.vue';
import ProfileUpdate from '../../pages/user/profile/Form.vue';

import Schedule from '../../pages/user/schedule/Schedule.vue';
import ScheduleForm from '../../pages/user/schedule/ScheduleForm.vue';

export default [
    {
        path: '/user/profile/view',
        component: ProfileView,
        name: 'userProfileView'
    },
    {
        path: '/user/profile/update',
        component: ProfileUpdate,
        name: 'userProfileUpdate'
    },

    {
        path: '/user/schedule',
        component: Schedule,
        name: 'userSchedule'
    },
    {
        path: '/user/schedule/create',
        component: ScheduleForm,
        name: 'userScheduleCreate',
        props: {
            type: 'create'
        }
    },
    {
        path: '/user/schedule/update/:id',
        component: ScheduleForm,
        name: 'userScheduleUpdate',
        props(route) {
            return {
                type: 'update',
                id: route.params.id
            }
        }
    },
];