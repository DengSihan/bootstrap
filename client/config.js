export default{
    app: {
        name: process.env.APP_NAME,
        description: process.env.APP_DESCRIPTION
    },
    locale: {
        default: process.env.APP_LOCALE,
        available: process.env.LOCALES_AVAILABLE.split(',')
    },
    api: {
        url: process.env.API_URL
    },
    social: [
        {
            key: 'github',
            icon: 'github',
            color: '#211F1F'
        },
        {
            key: 'apple',
            icon: 'apple',
            color: '#000000'
        },
        {
            key: 'weixin',
            icon: 'wechat',
            color: '#07c160'
        },
        {
            key: 'telegram',
            icon: 'telegram',
            color: '#0088cc'
        }
    ],
    theme: {
        default: 'light'
    }
}
