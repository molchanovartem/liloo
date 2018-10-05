export const APPOINTMENT_STATUS_COMPLETED = 1;
export const APPOINTMENT_STATUS_NEW = 2;
export const APPOINTMENT_STATUS_CONFIRMED = 3;
export const APPOINTMENT_STATUS_CANCELED = 4;
export const APPOINTMENT_STATUS_NOT_COME = 5;

export const appointmentStatus = {
    getStatusList() {
        return {
            [APPOINTMENT_STATUS_NEW]: 'Новый',
            [APPOINTMENT_STATUS_COMPLETED]: 'Выполнен',
            [APPOINTMENT_STATUS_CONFIRMED]: 'Подтвержден',
            [APPOINTMENT_STATUS_CANCELED]: 'Отменен',
            [APPOINTMENT_STATUS_NOT_COME]: 'Не пришел'
        };
    },

    getStatusName(status) {
        return this.getStatusList()[status];
    },

    isNew(status) {
        return +status === APPOINTMENT_STATUS_NEW;
    },

    isConfirmed(status) {
        return +status === APPOINTMENT_STATUS_CONFIRMED;
    },

    isCanceled(status) {
        return +status === APPOINTMENT_STATUS_CANCELED;
    },

    isNotCome(status) {
        return +status === APPOINTMENT_STATUS_NOT_COME;
    }
};