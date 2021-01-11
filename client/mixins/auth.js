import NameInput from '@/components/auth/form/name-input';
import PasswordInput from '@/components/auth/form/password-input';
import RememberMeCheckbox from '@/components/auth/form/remember-me-checkbox';
import CaptchaInput from '@/components/auth/form/captcha-input';
import Social from '@/components/auth/social';
import token from '@/mixins/token';
export default{
    mixins: [
        token
    ],
    components: {
        NameInput,
        PasswordInput,
        RememberMeCheckbox,
        CaptchaInput,
        Social
    },
    middleware: 'guest',
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
            this.loading = this.$vs.loading();
            this.$axios.post(api, {
                    captcha_key: this.captcha.key,
                    ...this.form
                })
                .then(({ data }) => {
                    this.handleToken(data);
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
