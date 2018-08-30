export const commonFilters = {
    filters: {
        currency: function (value) {
            return new Intl.NumberFormat('ru-RU', {style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2}).format(value);
        }
    }
};