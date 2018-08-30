import axios from 'axios';

export const HTTP = axios.create({
    //baseURL: 'http://lilu/api/v1/',
    baseURL: 'http://lilu/api_test/v1/',
    params: {
        token: 12345
    }
});