<template>
    <main class="mx-auto w-full sm:w-full md:w-2/3 lg:w-1/3 xl:w-1/4">
        <section class="p-2 sm:p-2 md:p-0">
            <h1 class="my-6 text-3xl">
                {{ $t('forget_password').toCapitalizePhrases() }}
            </h1>
            <form @submit.prevent="sendEmailVerification">
                <email-input
                    class="my-6"
                    v-model="form.email"
                    :errors="errors.email"/>
                <captcha-input
                    class="my-6"
                    v-model="form.verification"
                    :errors="errors.verification"
                    :captcha="captcha"
                    @refresh="refreshCaptcha()"/>
                <div class="my-6 flex justify-center">
                    <vs-button type="submit" square block class="m-0">
                        {{ $t('send_email_verification').toUpperCase() }}<i class="mdi mdi-send text-2xl pl-2"></i>
                    </vs-button>
                </div>
            </form>
            <div class="my-6 flex justify-between items-center">
                <nuxt-link
                    class="capitalize"
                    :to="generateRoute({ name: 'register' })">{{ $t('new_here') }}</nuxt-link>
                <nuxt-link
                    class="capitalize"
                    :to="generateRoute({ name: 'login' })">{{ $t('have_account') }}</nuxt-link>
            </div>
        </section>
        <vs-dialog
            square
            blur
            prevent-close
            not-close
            :value="show">
            <template #header>
                <h2 class="mt-4 mb-0">
                    {{ $t('check_verification').toCapitalizePhrases() }}
                </h2>
            </template>
            <form class="my-6" @submit.prevent="resetPassword">
                <email-verification-input
                    class="my-6"
                    v-model="form.email_verification"
                    :errors="errors.email_verification"/>
                <div class="my-6 flex justify-between">
                    <vs-button type="submit" block success square class="m-0">
                        {{ $t('send_email_verification').toUpperCase() }}<i class="mdi mdi-send text-2xl pl-2"></i>
                    </vs-button>
                </div>
            </form>
            <div class="my-6">
                <vs-button type="button" block square class="m-0" @click="closeDialog">
                    {{ $t('cancel').toUpperCase() }}<i class="mdi mdi-close text-2xl pl-2"></i>
                </vs-button>
            </div>
        </vs-dialog>
    </main>
</template>
<script type="text/javascript">
import auth from '@/mixins/auth';
export default{
    head(){
        return {
            title: this.$t('forget_password').toCapitalizePhrases()
        }
    },
    mixins: [
        auth
    ],
    data(){
        return {
            show: false
        }
    },
    methods: {
        sendEmailVerification(){
            this.$nuxt.$loading.start();
            this.loading = this.$vs.loading();
            this.$axios.post(`/auth/email-verifications`, {
                    captcha_key: this.captcha.key,
                    ...this.form
                })
                .then(({ data }) => {
                    this.$nuxt.$loading.finish();
                    this.loading.close();
                    this.show = true;
                })
                .catch(error => {
                    this.$nuxt.$loading.finish();
                    this.loading.close();
                    this.handleError(error);
                });
        },
        closeDialog(){
            this.refreshCaptcha();
            this.show = false;
        },
        resetPassword(){
            this.$nuxt.$loading.start();
            this.loading = this.$vs.loading();
            this.$axios.patch(`/auth/email-verifications`, this.form)
                .then(({ data }) => {
                    this.$nuxt.$loading.finish();
                    this.loading.close();

                    this.from = this.generateRoute({
                        name: 'account/update-password'
                    });
                    this.handleToken(data);
                })
                .catch(error => {
                    this.$nuxt.$loading.finish();
                    this.loading.close();
                    this.handleError(error);
                });

        }
    }
}
</script>
