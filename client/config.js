export default{
    locale: {
        default: process.env.APP_LOCALE,
        available: process.env.LOCALES_AVAILABLE.split(',')
    },
    api: {
        url: process.env.API_URL
    }
}
