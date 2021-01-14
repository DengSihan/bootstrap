import Echo from 'laravel-echo';
import Vue from 'vue';
import pusher from 'pusher-js';
import config from '@/config';

window.Pusher = pusher;

const echor = {
    install(Vue){
        Vue.prototype.$echo = token => {
            return new Echo({
                broadcaster: 'pusher',
                key: config.websockets.key,
                wsHost: config.websockets.host,
                wsPort: config.websockets.port,
                wssPort: config.websockets.port,
                forceTLS: false,
                disableStats: true,
                enabledTransports: ['ws', 'wss'],
                auth: {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            });
        }
    }
};

Vue.use(echor);
