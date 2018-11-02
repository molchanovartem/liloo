import Appointment from '../../pages/appointment/Appointment.vue';
import AppointmentList from '../../pages/appointment/List.vue';

export default [
    {
        path: '/appointment/manager',
        component: Appointment,
        name: 'appointmentManager'
    },
    {
        path: '/appointment/list',
        component: AppointmentList,
        name: 'appointmentList'
    }
];