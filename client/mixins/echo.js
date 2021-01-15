import Echo from 'laravel-echo';
import Vue from 'vue';
import pusher from 'pusher-js';
import config from '@/config';
import { mapGetters } from 'vuex';

export default{
    data(){
        return {
            joined: false,
            echor: null,
        }
    },
    computed: mapGetters({
        user: 'auth/user',
        token: 'auth/token'
    }),
    watch: {
        user: {
            handler(value, old){
                if (value) {
                    this.bootstrapEchor();
                    this.joinChannels();
                }
                else{
                    this.leaveChannels(old);
                }
            }
        }
    },
    mounted(){
        this.$nextTick(() => {
            if (!!this.user) {
                this.bootstrapEchor();
                this.joinChannels();
            }
        });
    },
    methods: {
        bootstrapEchor(){
            if (!window.Pusher) {
                window.Pusher = pusher;
            }
            if (!this.echor) {
                this.echor = new Echo({
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
                            Authorization: `Bearer ${this.token}`
                        }
                    }
                });
            }
        },
        joinChannels(){
            if (!this.joined) {
                this.echor.private(`App.Models.User.${this.user.id}`)
                    .listen(`EventNotification`, event => {
                        console.log(event);
                    })
                    .notification(notification => {
                        console.log('from notification', notification);
                    });
                this.joined = true;
            }
        },
        leaveChannels(user){
            this.echor.leave(`App.Models.User.${user.id}`);
        }
    }
}
