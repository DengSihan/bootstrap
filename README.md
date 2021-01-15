<p align="center" style="margin:2rem -0.5rem;"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" style="margin:0rem 0.5rem;" height="100"/><img style="margin:0rem 0.5rem;" src="https://github.com/nuxt/nuxt.js/raw/dev/.github/nuxt.png" height="100"/></p>

# Nuxt-Laravel Quick Bootstrap Template
Start your project that has perfect SEO and user experience which is composed of Nuxtjs as its frontend and Laravel as backend.

### Install
```shell
composer create-project dengsihan/laravel-nuxt-bootstrap
php artisan migrate
npm install --no-bin-links
php artisan websockets:serve &
npm run dev
```

### Features
1. [**Nuxtjs**](https://nuxtjs.org/) in SSR
2. [**Laravel**](https://laravel.com/) backend
3. [**Tailwind** for Nuxtjs](https://tailwindcss.nuxtjs.org/)
4. [**Vuesax** (with light/dark mode)](http://vuesax.com/)
5. **PWA** support
6. **I18n** support
7. Get [**Elasticsearch**](https://github.com/elastic/elasticsearch) started quickly 
8. **Websockets** by [Laravel-Echo](https://github.com/laravel/echo)

### Content
1. Authorizations System by Email with Social Accounts Support (default: github\apple\weixin\telegram, by [Socialite Providers](https://socialiteproviders.netlify.com/))

### Notices
1. nginx config
    ```
    proxy_set_header X-Forwarded-For $remote_addr;

    location ~* ^/(api|broadcasting)/ {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location / {
        proxy_pass http://127.0.0.1:3000;
    }
    ```
2. Supervisor for websockets
    ```shell
    [program:websockets]
    command=/usr/bin/php /your-project-location/artisan websockets:serve
    numprocs=1
    autostart=true
    autorestart=true
    user=sudo-www
    ```

### License
MIT
