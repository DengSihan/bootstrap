require('dotenv').config();

module.exports = {

    srcDir: __dirname,

    plugins:[
        '~plugins/axios',
        '~/plugins/vuesax',
        '~/plugins/fragment',
        '~/plugins/i18n',
        '~/plugins/helper',
        { src: '~/plugins/lazyload', ssr: false },
        { src: '~/plugins/localforage', ssr: false },
        { src: '~/plugins/waves-effect', ssr: false },
        '~/mixins/global',
    ],

    buildModules: [
        '@nuxtjs/router',
        '@nuxtjs/tailwindcss',
        '@nuxtjs/pwa',
        '@nuxtjs/axios',

        // share .env file for both Nuxt and Laravel
        ['@nuxtjs/dotenv', {
            path: `${__dirname}/../`,
            only: [
                'APP_NAME',
                'APP_DESCRIPTION',
                'APP_URL',
                'API_URL',
                'APP_LOCALE',
                'LOCALES_AVAILABLE',
                'PUSHER_APP_KEY',
                'WEBSOCKETS_DOMAIN',
                'WEBSOCKETS_PORT'
            ]
        }]
    ],

    router: {
        middleware: [
            'locale',
            'check-auth'
        ]
    },

    head: {
        titleTemplate: `%s | ${process.env.APP_NAME}`,
        link: [
            {
                rel: 'icon',
                type: 'image/x-icon',
                href: '/favicon.ico'
            }
        ],
        meta: [
            {
                charset: 'utf-8'
            },
            {
                name: 'viewport',
                content: 'width=device-width, initial-scale=1'
            }
        ]
    },

    css: [
        '~/assets/app.scss',
    ],
    tailwindcss: {
        cssPath: '~/assets/tailwind.css',
    },

    // pwa configs
    pwa: {
        icon: {
            fileName: 'logo.png',
            sizes: [144]
        },
        manifest: {
            name: process.env.APP_NAME,
            description: process.env.APP_DESCRIPTION,
            short_name: process.env.APP_NAME
        }
    },

    // nuxt ssr cache
    // https://github.com/arash16/nuxt-ssr-cache
    version: (new Date()).getTime(),
    modules: [
        'nuxt-ssr-cache',
    ],
    cache: process.env.NODE_ENV === 'production' ? null : {
        useHostPrefix: false,
        pages: [
            /^\/$/
        ],
        store: {
            type: 'memory',
            max: 100,
            ttl: 60,
        }
    },

    /**
     * listen to files changing
     */
    watchers: process.env.NODE_ENV === 'production' ? null : {
        webpack: {
            aggregateTimeout: 300,
            poll: 1000
        }
    }
}
