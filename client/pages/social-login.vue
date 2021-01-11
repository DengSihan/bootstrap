<template>
    <main class="mx-auto w-full sm:w-full md:w-2/3 lg:w-1/3 xl:w-1/4">
        <section class="p-2 sm:p-2 md:p-0">
            <h1 class="my-6 text-3xl">
                {{ $t('login').toCapitalizePhrases() }}
            </h1>
            <form @submit.prevent="login">
                <name-input
                    class="my-6"
                    v-model="form.name"
                    :errors="errors.name"/>
                <password-input
                    class="my-6"
                    v-model="form.password"
                    :name="`new-password`"
                    :errors="errors.password"/>
                <captcha-input
                    class="my-6"
                    v-model="form.verification"
                    :errors="errors.verification"
                    :captcha="captcha"
                    @refresh="refreshCaptcha()"/>
                <remember-me-checkbox
                    class="my-6"
                    v-model="remember"/>
                <div class="my-6">
                    <vs-button
                        success
                        square
                        block
                        type="submit"
                        data-action="new"
                        class="capitalize m-0">
                        {{ $t('login_as_new_user').toUpperCase() }}<i class="mdi mdi-account-plus text-2xl pl-2"></i>
                    </vs-button>
                </div>
                <div class="my-6">
                    <vs-button
                        square
                        block
                        type="submit"
                        data-action="exist"
                        class="capitalize m-0">
                        {{ $t('bind_to_exist_account').toUpperCase() }}<i class="mdi mdi-account-network text-2xl pl-2"></i>
                    </vs-button>
                </div>
            </form>
        </section>
    </main>
</template>
<script type="text/javascript">
import auth from '@/mixins/auth';
import { localeFromRequest } from '@/utils';
import config from '@/config';
export default{
    mixins: [
        auth
    ],
    head(){
        return {
            title: this.$t('login').toCapitalizePhrases()
        }
    },
    asyncData({ $axios, redirect, route, request }){
        if (!route.query.social) {
            let locale = localeFromRequest(route.fullPath);
            redirect(`${locale === config.locale.default ? '' : `/${locale}`}/login`);
        }
        else{
            return $axios.post(`/auth/captchas`)
                .then(({ data }) => {
                    return {
                        captcha: data
                    }
                });
        }
    },
    methods: {
        login(e){
            let action = e.submitter.getAttribute('data-action');

            this.$nuxt.$loading.start();
            this.loading = this.$vs.loading();

            this.$axios.post(`/auth/socials/authorizations`, {
                    social: this.$route.query.social,
                    action: action,
                    captcha_key: this.captcha.key,
                    ...this.form
                })
                .then(({ data }) => {
                    this.handleToken(data);
                })
                .catch(error => {
                    this.$nuxt.$loading.finish();
                    this.loading.close();
                    this.handleError(error);

                    for(const [key, value] of Object.entries(error.response.data.errors)){
                        if (key === 'social') {
                            this.$router.push(this.generateRoute({
                                name: 'login'
                            }));
                        }
                    }
                });
        }
    }
}
</script>
