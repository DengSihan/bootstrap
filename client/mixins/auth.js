import NameInput from '@/components/auth/form/name-input';
import PasswordInput from '@/components/auth/form/password-input';
import RememberMeCheckbox from '@/components/auth/form/remember-me-checkbox';
import CaptchaInput from '@/components/auth/form/captcha-input';
export default{
    components: {
        NameInput,
        PasswordInput,
        RememberMeCheckbox,
        CaptchaInput
    },
    data(){
        return {
            remember: false,

            form: {
                name: '',
                password: '',
                verification: ''
            },

            errors: {
                name: [],
                password: [],
                verification: []
            }
        }
    },
    asyncData({ $axios }){
        return $axios.post(`/auth/captchas`)
            .then(({ data }) => {
                return {
                    captcha: data
                }
            });
    },
    watch: {
        'form.name'(value){
            if (value) this.errors.name = [];
        },
        'form.password'(value){
            if (value) this.errors.password = [];
        },
        'form.verification'(value){
            if (value) this.errors.verification = [];
        }
    },
    methods: {
        refreshCaptcha(){
            this.$axios.post(`/auth/captchas`)
                .then(({ data }) => {
                    this.captcha = data;
                });
        },
        makeRequest(api){
            this.$nuxt.$loading.start();
            const loading = this.$vs.loading();
            this.$axios.post(api, {
                    captcha_key: this.captcha.key,
                    ...this.form
                })
                .then(({ data }) => {
                    this.$nuxt.$loading.increase(50);
                    // save the token.
                    this.$store.dispatch('auth/saveToken', {
                        token: data.access_token,
                        remember: this.remember
                    });

                    // fetch the user.
                    this.$store.dispatch('auth/fetchUser').then(() => {
                        this.$nuxt.$loading.finish();
                        loading.close();
                        this.$router.push(this.$route.query.from || '/');
                    });
                })
                .catch(error => {
                    this.$nuxt.$loading.finish();
                    loading.close();
                    this.handleError(error);
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
