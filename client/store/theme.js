import Cookie from 'js-cookie';

export const namespace = true;

export const state = () => ({
    theme: 'system'
});

export const getters = {
    theme: state => state.theme
};

export const mutations = {
    setTheme(state, theme){
        state.theme = theme;
        Cookie.set('theme', theme, 365);
    }
};
