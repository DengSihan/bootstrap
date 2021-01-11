import CaptchaInput from '@/components/auth/form/captcha-input';
export default{
    components: {
        CaptchaInput
    },
    asyncData({ $axios }){
        return $axios.post(`/auth/captchas`)
            .then(({ data }) => {
                return {
                    captcha: data
                }
            });
    },
    methods: {
        refreshCaptcha(){
            this.$axios.post(`/auth/captchas`)
                .then(({ data }) => {
                    this.captcha = data;
                });
        },
        handleError(error){
            this.$nuxt.$loading.finish();
            this.refreshCaptcha();
            this.handleAxiosError(error);
            for(const [key, value] of Object.entries(error.response.data.errors)){
                this.errors[key] = value;
            }
        }
    }
}
