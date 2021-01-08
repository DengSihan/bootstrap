export default{
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
        }
    ]
}
