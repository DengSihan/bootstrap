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

### Deploy Guide
Steps for deploying this project by [deployer](https://deployer.org/)
1. install [deployer](https://deployer.org/) globally
    ```shell
    composer global require deployer/deployer
    ```
2. create a new deployer script for Laravel
    ```
    dep init
    ```
3. add script like this in your `deploy.php`
    ```
    <?php
    namespace Deployer;
    require 'recipe/laravel.php';

    // Project repository
    set('repository', 'git@github.com:dengsihan/bootstrap.git');

    // Shared files/dirs between deploys 
    add('shared_files', []);
    add('shared_dirs', []);

    // Writable dirs by web server 
    add('writable_dirs', []);

    // Tasks
    // upload .env
    task('env:upload', function () {
        upload('.env', '{{release_path}}/.env');
    });
    after('deploy:shared', 'env:upload');

    task('deploy_helper:upload', function () {
        upload('nuxtjs.sh', '{{release_path}}/nuxtjs.sh');
        run('dos2unix {{release_path}}/nuxtjs.sh');
    });
    after('env:upload', 'deploy_helper:upload');

    // reset route cache
    task('reset:cache', function () {
        run('{{bin/php}} {{release_path}}/artisan route:cache');
    });
    after('artisan:migrate', 'reset:cache');

    // copy relies
    add('copy_dirs', ['node_modules', 'vendor']);
    before('deploy:vendors', 'deploy:copy_dirs');

    // update front end
    task('deploy:npm', function () {
        run('cd {{release_path}} && ./nuxtjs.sh', ['timeout' => 600]);
    });
    after('deploy:vendors', 'deploy:npm');

    // Hosts
    host('ip')
        ->user('www-data')
        ->identityFile('~/.ssh/id_rsa')
        ->set('deploy_path', '/deploy/path/in/your/server');

    // [Optional] if deploy fails automatically unlock.
    after('deploy:failed', 'deploy:unlock');

    // Migrate database before symlink new release.
    before('deploy:symlink', 'artisan:migrate');
    ```
    `nuxtjs.sh`
    ```shell
    #!/bin/bash
    old_port=3001
    new_port=3000

    # check which port nuxtjs is running
    is_3000_using=$(lsof -t -i:3000)
    if [ -n "$is_3000_using" ]; then
        old_port=3000
        new_port=3001
    fi

    # update package.json
    sed -i "s/$old_port/$new_port/g" package.json

    npm install

    #build
    build=$(npm run build)
    if [[ $result =~ "ERR" ]]; then
        echo "--$build"
    else
        pm2 start npm --name "nuxt-$new_port" -- run start

        # update nginx
        sed -i "s/$old_port/$new_port/g" /etc/nginx/sites-available/example.com.conf
        service nginx reload

        old_pm2_process=$(pm2 list | grep "nuxt-$old_port")
        if [ -n "$old_pm2_process" ]; then
            pm2 delete "nuxt-$old_port";
        fi
    fi
    ```
    for more details please read [here](https://dengsihan.medium.com/deploy-a-ssr-nuxtjs-with-laravel-backend-by-deployer-smoothly-%E4%BD%BF%E7%94%A8-deployer-%E5%B9%B3%E6%BB%91%E9%83%A8%E7%BD%B2%E4%B8%80%E4%B8%AA%E4%BB%A5-laravel-%E4%B8%BA%E5%90%8E%E7%AB%AF%E7%9A%84-ssr-fef84c367c99)
### License
MIT
