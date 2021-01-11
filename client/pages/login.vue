<template>
    <main class="mx-auto w-full sm:w-full md:w-2/3 lg:w-1/3 xl:w-1/4">
        <section class="p-2 sm:p-2 md:p-0">
            <h1 class="my-6 text-3xl">
                {{ $t('login').toCapitalizePhrases() }}
            </h1>
            <form @submit.prevent="makeRequest(`/auth/authorizations`)">
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
                        {{ $t('login').toUpperCase() }}<i class="mdi mdi-send text-2xl pl-2"></i>
                    </vs-button>
                </div>
            </form>
            <social class="my-10"/>
        </section>
    </main>
</template>
<script type="text/javascript">
import auth from '@/mixins/auth';
export default{
    head(){
        return {
            title: this.$t('login').toCapitalizePhrases()
        }
    },
    mixins: [
        auth
    ]
}
</script>
