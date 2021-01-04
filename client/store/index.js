import { cookieFromRequest } from '~/utils';

export const actions = {

    nuxtServerInit({ commit, dispatch, route }, { req }){
        const token = cookieFromRequest(req, 'token');
        if (!!token) {
            commit('auth/setToken', token);
        }
    }
};
