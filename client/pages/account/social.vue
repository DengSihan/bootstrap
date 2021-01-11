<template>
    <main>
        <ul>
            <li v-for="social in socials"
                :key="social.key">
                <i class="mdi text-2xl pr-2"
                    :class="`mdi-${social.icon}`"
                    :style="{
                        color: social.color
                    }"></i>
                <template v-if="data[social.key]">
                    <form @submit.prevent="unbind(social.key)">
                        <vs-button danger type="submit" square>
                            {{ $t('unbind') }}
                        </vs-button>
                    </form>
                </template>
                <template v-else>
                    <form @submit.prevent="bind(social.key)">
                        <vs-button type="submit" square>
                            {{ $t('bind') }}
                        </vs-button>
                    </form>
                </template>
            </li>
        </ul>
    </main>
</template>
<script type="text/javascript">
import config from '@/config';
export default{
    head(){
        return {
            title: this.$t('social_account').toCapitalizePhrases()
        }
    },
    middleware: 'auth',
    asyncData({ $axios }){
        return $axios.get(`/auth/user/social`)
            .then(({ data }) => {
                return {
                    data: data
                }
            });
    },
    data(){
        return {
            socials: config.social
        }
    },
    methods: {
        unbind(type){

        },
        bind(type){

        }
    }
}
</script>
