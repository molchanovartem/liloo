const STATUS_NEW = 1,
    STATUS_NOT_CONFIRMED = 2,
    STATUS_CONFIRMED = 3,
    STATUS_CANCELED = 4;

export default class Status {
    getStatusList() {
        return {
            [STATUS_NEW]: 'Новый',
            [STATUS_NOT_CONFIRMED]: 'Не подтвержден',
            [STATUS_CONFIRMED]: 'Подтвержден',
            [STATUS_CANCELED]: 'Отменен'
        };
    }

    getStatusName(status) {
        return this.getStatusList()[status];
    }

    isNew(status) {
        return +status === STATUS_NEW;
    }

    isNotConfirmed(status) {
        return +status === STATUS_NOT_CONFIRMED;
    }

    isConfirmed(status) {
        return +status === STATUS_CONFIRMED;
    }

    isCanceled(status) {
        return +status === STATUS_CANCELED;
    }
}