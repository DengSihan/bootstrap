<template>
    <main class="mx-auto w-full sm:w-full md:w-2/3 lg:w-1/3 xl:w-1/4">
        <ul>
            <li v-for="social in socials"
                :key="social.key"
                v-if="data[social.key]"
                class="flex justify-between items-center">
                <i class="mdi text-3xl pr-2"
                    :class="`mdi-${social.icon}`"
                    :style="{
                        color: social.color
                    }"></i>
                <form @submit.prevent="unbind(social.key)">
                    <vs-button danger type="submit" square>
                        {{ $t('unbind').toUpperCase() }}<i class="mdi mdi-account-remove text-2xl pl-2"></i>
                    </vs-button>
                </form>
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
            let loading = this.$vs.loading();
            this.$axios.delete(`/auth/user/social/${type}`)
                .then(() => {
                    this.reloadSocialInfo();
                    loading.close();
                })
                .catch(error => {
                    loading.close();
                });
        },
        reloadSocialInfo(){
            this.$axios.get(`/auth/user/social`)
                .then(({ data }) => {
                    this.data = data;
                });
        }
    }
}
</script>
