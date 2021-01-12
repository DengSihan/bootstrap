<template>
    <main class="mx-auto w-full sm:w-full md:w-2/3 lg:w-1/3 xl:w-1/4">
        <section class="p-2 sm:p-2 md:p-0">
            <h1 class="my-6 text-3xl">
                {{ $t('logging_in').toCapitalizePhrases() }}
            </h1>
        </section>
    </main>
</template>
<script type="text/javascript">
import token from '@/mixins/token';
export default{
    mixins: [
        token
    ],
    head(){
        return {
            title: this.$t('logging_in').toCapitalizePhrases()
        }
    },
    mounted(){
        this.$nextTick(() => {
            if (this.$route.params.certificate) {
                this.$nuxt.$loading.start();
                this.loading = this.$vs.loading();
                this.$axios.post(`/auth/socials/tokens`, {
                        certificate: this.$route.params.certificate
                    })
                    .then(({ data }) => {
                        this.handleToken(data);
                    })
                    .catch(error => {
                        this.$nuxt.$loading.finish();
                        this.loading.close();
                        this.handleAxiosError(error);
                        this.$router.push(this.generateRoute({
                            name: 'login'
                        }));
                    });
            }
        });
    }
}
</script>
