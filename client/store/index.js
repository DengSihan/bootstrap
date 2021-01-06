import { cookieFromRequest, localeFromRequest } from '~/utils';

export const actions = {

    nuxtServerInit({ commit, dispatch, route }, { req }){
        const token = cookieFromRequest(req, 'token');
        if (!!token) {
            commit('auth/setToken', token);
        }

        const locale = localeFromRequest(req);
        if (!!locale) {
            commit('locale/setLocale', locale);
        }
    }
};
