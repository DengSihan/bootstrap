import config from '@/config';

export const namespace = true;

export const state = () => ({
    locale: config.locale.default,
    locales_available: config.locale.available,
    default_locale: config.locale.default
});

export const getters = {
    locale: state => state.locale
};

export const mutations = {
    setLocale(state, locale){
        state.locale = locale;
    }
};
