import validate from 'validate.js';

export const formRules = {
    required(value) {
        return formRules.validate(value, {presence: {allowEmpty: false}}, 'Обязательное');
    },
    length(value, params) {
        return formRules.validate(String(value), {length: params}, 'ой, ошибка');
    },
    number(value, params) {
        return formRules.validate(value, {numericality: params}, 'Неправильный формат числа');
    },
    in(value, range) {
        return formRules.validate(value, {inclusion: range}, 'Неправильное значение');
    },

    validate(value, params, message) {
        let validMessage = typeof message === 'function' ? message(value) : message;

        return validate({input: value}, {input: params}) === undefined || validMessage;
    }
};