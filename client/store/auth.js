import axios from 'axios';
import Cookie from 'js-cookie';

export const state = () => ({
    user: null,
    token: null
});

export const getters = {
    user: state => state.user,
    token: state => state.token,
    check: state => state.user !== null
};

export const mutations = {
    setToken(state, token){
        state.token = token;
    },
    fetchUserSuccess(state, user){
        state.user = user;
    },
    fetchUserFailure(state){
        state.user = null;
    },
    logout(state){
        state.token = null;
        state.user = null;
    },
    updateUser(state, { user }){
        state.user = user;
    }
}

export const actions = {
    saveToken({ commit }, { token, remember }){
        commit('setToken', token);
        Cookie.set('token', token, { expires: remember ? 365 : null });
    },
    async fetchUser({ commit }){
        try{
            const { data } = await axios.get('/auth/user');
            commit('fetchUserSuccess', data);
        }catch(e){
            Cookie.remove('token');
            commit('fetchUserFailure');
        }
    },
    updateUser({ commit }, payload){
        commit('updateUser', payload);
    },
    async logout({ commit }){
        try{
            await axios.delete('/auth/authorizations');
        }catch(e){}
        Cookie.remove('token');
        commit('logout');
    }
}
