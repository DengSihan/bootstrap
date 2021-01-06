import Vue from 'vue';
import VueI18n from 'vue-i18n';
import config from '@/config';

Vue.use(VueI18n);

let messages = Object;

config.locale.available.forEach(locale => {
    messages[locale] = require(`~/locales/${locale}.json`);
});

export default ({ app, store }) => {
    app.i18n = new VueI18n({
        locale: store.state.locale.locale,
        messages: messages
    });
}
