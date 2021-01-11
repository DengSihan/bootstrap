import NameInput from '@/components/auth/form/name-input';
import PasswordInput from '@/components/auth/form/password-input';
import RememberMeCheckbox from '@/components/auth/form/remember-me-checkbox';
import Social from '@/components/auth/social';
import token from '@/mixins/token';
import captcha from '@/mixins/captcha';
export default{
    mixins: [
        token,
        captcha
    ],
    components: {
        NameInput,
        PasswordInput,
        RememberMeCheckbox,
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
                    this.loading.close();
                    this.handleError(error);
                });
        }
    }
}
