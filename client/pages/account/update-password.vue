<template>
    <main class="mx-auto w-full sm:w-full md:w-2/3 lg:w-1/3 xl:w-1/4">
        <section class="p-2 sm:p-2 md:p-0">
            <h1 class="my-6 text-3xl">
                {{ $t('update_password').toCapitalizePhrases() }}
            </h1>
            <form @submit.prevent="updatePassword">
                <password-input
                    class="my-6"
                    v-model="form.password"
                    :errors="errors.password"
                    :name="`new-password`"/>
                <captcha-input
                    class="my-6"
                    v-model="form.verification"
                    :errors="errors.verification"
                    :captcha="captcha"
                    @refresh="refreshCaptcha()"/>
                <div class="my-6 flex justify-center">
                    <vs-button type="submit" square block class="m-0">
                        {{ $t('update_password').toUpperCase() }}<i class="mdi mdi-send text-2xl pl-2"></i>
                    </vs-button>
                </div>
            </form>
        </section>
    </main>
</template>
<script type="text/javascript">
import PasswordInput from '@/components/auth/form/password-input';
import captcha from '@/mixins/captcha';
export default{
    mixins: [
        captcha
    ],
    components: {
        PasswordInput
    },
    middleware: 'auth',
    head(){
        return {
            title: this.$t('update_password').toCapitalizePhrases()
        }
    },
    data(){
        return {
            form: {
                password: '',
                verification: ''
            },

            errors: {
                password: [],
                verification: []
            }
        }
    },
    watch: {
        'form.password'(value){
            if (value) this.errors.password = [];
        },
        'form.verification'(value){
            if (value) this.errors.verification = [];
        }
    },
    methods: {
        updatePassword(){
            this.$nuxt.$loading.start();
            let loading = this.$vs.loading();
            this.$axios.put(`/auth/user/password`, {
                    captcha_key: this.captcha.key,
                    ...this.form
                })
                .then(() => {
                    this.$nuxt.$loading.finish();
                    loading.close();
                    this.$router.push(this.generateRoute({
                        name: 'account'
                    }));
                })
                .catch(error => {
                    this.$nuxt.$loading.finish();
                    loading.close();
                    this.handleError(error);
                });
        }
    }
}
</script>
