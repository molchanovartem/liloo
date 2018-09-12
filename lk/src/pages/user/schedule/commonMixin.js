import dateFormat from 'dateformat';

export default {
    methods: {
        formatTime(startDate, endDate) {
            function formatNumber(number) {
                return +number < 10 ? '0' + number : number;
            }

            function getTime(date) {
                return formatNumber(date.getHours()) + ':' + formatNumber(date.getMinutes());
            }

            return getTime(startDate) + ' - ' + getTime(endDate);
        },
        dateFormat(date) {
            return dateFormat(date, 'yyyy-mm-dd HH:MM:ss');
        }
    }
};