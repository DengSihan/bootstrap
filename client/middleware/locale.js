import config from '@/config';

export default function ({ isHMR, app, store, route, params, error, redirect }) {
    // If middleware is called from hot module replacement, ignore it
    if (isHMR) { return }

    const locale = params.locale || config.locale.default,
          defaultLocale = config.locale.default,
          localesAvailable = config.locale.available;

    if (localesAvailable.includes(locale)) {
        app.i18n.locale = locale;
        if (store.state.locale.locale !== locale) {
            store.commit('locale/setLocale', locale);
        }
    }
    else{
        return error({ message: 'Page Not Found', statusCode: 404 });
    }

    // If route is /{APP_LOCALE}/... -> redirect to /...
    if (locale === defaultLocale && route.fullPath.indexOf(`/${defaultLocale}`) === 0) {
        const to_replace = `^/${defaultLocale}` + (route.fullPath.indexOf(`/${defaultLocale}/`) === 0 ? '/' : '');
        const re = new RegExp(to_replace);
        return redirect(
            route.fullPath.replace(re, '/')
        );
    }
}
