<template>
    <main>
        <h1 class="capitalize">
            index
        </h1>
        <ul>
            <template v-if="!logged">
                <li>
                    <nuxt-link :to="generateRoute({name: 'login'})">
                        {{ $t('login') }}
                    </nuxt-link>
                </li>
                <li>
                    <nuxt-link :to="generateRoute({name: 'register'})">
                        {{ $t('register') }}
                    </nuxt-link>
                </li>
            </template>
            <template v-else>
                <li>
                    <nuxt-link :to="generateRoute({name: 'logout'})">
                        {{ $t('logout') }}
                    </nuxt-link>
                </li>
                <li>
                    <nuxt-link :to="generateRoute({name: 'account'})">
                        {{ $t('account') }}
                    </nuxt-link>
                </li>
                <vs-button @click="notify()">
                    send notification
                </vs-button>
            </template>
        </ul>
    </main>
</template>
<script type="text/javascript">
import config from '@/config';
export default{
    head(){
        return {
            title: `${config.app.name} | ${config.app.description}`,
            titleTemplate: null
        }
    },
    mounted(){
        if (this.logged) {

            this.$echo(this.$store.getters['auth/token'])
                .join(`users`)
                .here(users => {
                    console.log(users)
                })
                .joining(user => {
                    console.log(user)
                })
                .leaving(user => {
                    console.log(user)
                });

            this.$echo(this.$store.getters['auth/token'])
                .private(`users.${this.$store.getters['auth/user']['id']}`)
                .listen(`SendNotification`, event => {
                    console.log(event)
                });
        }
    },
    methods: {
        notify(){
            this.$axios.post(`/users/notifications`);
        }
    }
}
</script>
