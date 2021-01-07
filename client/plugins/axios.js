import config from '@/config';

export default ({ $axios, store, req, error:nuxtError  }) => {

    $axios.setBaseURL(config.api.url);

    const token = store.getters['auth/token'];
    if (token) {
        $axios.setToken(token, 'Bearer')
    }

    const locale = store.getters['locale/locale'];
    if (locale) {
        $axios.setHeader('Accept-Language', locale);
    }

    if (process.server) {
        $axios.setHeader('X-Forwarded-For', req.headers['x-forwarded-for']);
    }


    $axios.onResponseError(error => {

        const { status } = error.response || {};

        if (status === 401 && store.getters['auth/check']) {
            store.commit('auth/logout');
        }
        else{
            nuxtError({
                statusCode: error.response.status,
                message: error.response.statusText,
                detail: error.response.data.message
            });
        }
        return Promise.resolve(false);
    });
}

