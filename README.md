## Nuxt-Laravel Quick Bootstrap Template
Start your project that has perfect SEO and user experience which is composed of Nuxtjs as its frontend and Laravel as backend.

### Features
1. [Nuxtjs](https://nuxtjs.org/) in SSR
2. [Laravel](https://laravel.com/) backend
3. [Tailwind for Nuxtjs](https://tailwindcss.nuxtjs.org/)
4. [Vuesax](http://vuesax.com/)

### Notices
1. nginx config
    ```
    proxy_set_header X-Forwarded-For $remote_addr;

    location /api/ {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location / {
        proxy_pass http://127.0.0.1:3000;
    }
    ```
