import UIkit from 'uikit/dist/js/uikit.min';

export const notificationPlugin = {
    install(Vue, options) {
        //  Логика подключения

        Vue.prototype.$notification = notification;

        function notification(message, status = 'default') {
            UIkit.notification({
                message: message,
                status: status,
                pos: 'top-right',
                timeout: 5000
            });
        }

        notification.save = function() {
            let fn = this;

            fn('Сохранено!', 'primary');
        };

        notification.delete = function() {
            let fn = this;

            fn('Удалено!', 'primary');
        };
    }
};