import axios from 'axios';

export default ({ app, store, redirect }) => {

    axios.default.baseURL = process.env.API_URL;

    // Request interceptor
    axios.interceptors.request.use(request => {

        request.baseURL = process.env.API_URL;

        const token = store.getters['auth/token'];
        if (token) {
            request.headers.common.Authorization = `Bearer ${token}`;
        }

        const locale = store.getters['locale/locale'];
        if (locale) {
            request.headers.common.Language = locale;
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

