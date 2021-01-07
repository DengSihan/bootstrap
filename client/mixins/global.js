import Vue from 'vue';
import config from '@/config';
Vue.mixin({
    methods: {
        handleAxiosError(error){
            this.notify({
                color: 'danger',
                icon: `<i class="mdi-alert-circle mdi text-2xl"></i>`,
                title: `${error.response.status} ${error.response.statusText}`,
                text: error.response.data.message
            });
        },
        notify(options){
            this.$vs.notification({
                square: true,
                position: 'bottom-right',
                color: 'primary',
                progress: 'auto',
                duration: 6000,
                ...options
            });
        },
        // add locale to route
        generateRoute(route){
            if (route.params) {
                if (route.params.locale) {
                    if (route.params.locale === config.locale.default) {
                        delete route.params.locale
                    }
                }
                else{
                    if (this.$store.state.locale.locale !== config.locale.default) {
                        route.params = {
                            locale: this.$store.state.locale.locale,
                            ...route.params,
                        };
                    }
                }
            }
            else{
                if (this.$store.state.locale.locale !== config.locale.default) {
                    route.params = {
                        locale: this.$store.state.locale.locale
                    };
                }
            }
            return route;
        }
    }
});
