<template>
    <main class="mx-auto w-full sm:w-full md:w-2/3 lg:w-1/3 xl:w-1/4">
        <section class="p-2 sm:p-2 md:p-0">
            <h1 class="my-6 text-3xl">
                {{ $t('register').toCapitalizePhrases() }}
            </h1>
            <form @submit.prevent="makeRequest(`/auth/users`)">
                <email-input
                    class="my-6"
                    v-model="form.email"
                    :errors="errors.email"/>
                <password-input
                    class="my-6"
                    v-model="form.password"
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
                <div class="my-6 flex justify-center">
                    <vs-button type="submit" square block class="m-0">
                        {{ $t('register').toUpperCase() }}<i class="mdi mdi-send text-2xl pl-2"></i>
                    </vs-button>
                </div>
            </form>
            <div class="my-6 flex justify-between items-center">
                <nuxt-link
                    class="capitalize"
                    :to="generateRoute({ name: 'forget-password' })">{{ $t('forget_password') }}</nuxt-link>
                <nuxt-link
                    class="capitalize"
                    :to="generateRoute({ name: 'login' })">{{ $t('have_account') }}</nuxt-link>
            </div>
            <social class="my-10"/>
        </section>
    </main>
</template>
<script type="text/javascript">
import auth from '@/mixins/auth';
export default{
    head(){
        return {
            title: this.$t('register').toCapitalizePhrases()
        }
    },
    mixins: [
        auth
    ]
}
</script>
