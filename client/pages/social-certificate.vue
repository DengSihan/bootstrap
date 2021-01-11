<template>
    <main></main>
</template>
<script type="text/javascript">
import token from '@/mixins/token';
export default{
    mixins: [
        token
    ],
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
