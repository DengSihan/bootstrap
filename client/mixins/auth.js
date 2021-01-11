import NameInput from '@/components/auth/form/name-input';
import PasswordInput from '@/components/auth/form/password-input';
import RememberMeCheckbox from '@/components/auth/form/remember-me-checkbox';
import CaptchaInput from '@/components/auth/form/captcha-input';
import Social from '@/components/auth/social';
export default{
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
            },

            loading: null
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
        handleToken(data){
            this.$nuxt.$loading.increase(50);
            // save the token.
            this.$store.dispatch('auth/saveToken', {
                token: data.access_token,
                remember: this.remember
            });

            // fetch the user.
            this.$store.dispatch('auth/fetchUser').then(() => {
                this.$nuxt.$loading.finish();
                this.loading ? this.loading.close() : true;
                this.$router.push(this.logged ? this.$route.query.from || '/' : this.$route.path);
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
