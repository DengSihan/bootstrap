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
                        logout
                    </nuxt-link>
                </li>
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
    }
}
</script>
