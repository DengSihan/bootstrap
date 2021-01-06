import axios from 'axios';
import config from '@/config';

export default ({ app, store, redirect, req } ) => {

    axios.default.baseURL = config.api.url;

    // Request interceptor
    axios.interceptors.request.use(request => {

        request.baseURL = config.api.url;

        const token = store.getters['auth/token'];
        if (token) {
            request.headers.common.Authorization = `Bearer ${token}`;
        }

        const locale = store.getters['locale/locale'];
        if (locale) {
            request.headers.common['Accept-Language'] = locale;
        }

        if (process.server) {
            request.headers.common['X-Forwarded-For'] = req.headers['x-forwarded-for'];
        }

        return request;
    });

    // Response interceptor
    axios.interceptors.response.use(response => response, error => {

        const { status } = error.response || {};

        if (status >= 500) {
            console.log(status, response);
        }
        else if (status === 401 && store.getters['auth/check']) {
            store.commit('auth/logout');
        }

        return Promise.reject(error);
    });

}

