import lodash from 'lodash';
import { removeEmptyKeyInObject } from '~/utils';
export default{
    data(){
        return {
            page: this.$route.query.page || 1,
            filter: {
                category_id: this.$route.query.category_id || '',
                attributes: this.$route.query.attributes || '',
                keyword: this.$route.query.keyword || '',
                order: this.$route.query.order || ''
            }
        }
    },
    watch: {
        'filter': {
            handler(filter){
                this.$router.push(this.generateRoute({
                    name: this.$route.name,
                    query: removeEmptyKeyInObject(filter)
                }));
            },
            immediate: false,
            deep: true
        },
        '$route.query': {
            handler(query){
                this.debouncedGetData(query);
            },
            immediate: false,
            deep: true
        }
    },
    created(){
        this.debouncedGetData = lodash.debounce(this.getData, 1000);
    },
    methods: {
        changePage(page){
            this.$router.push(this.generateRoute({
                name: this.$route.name,
                query: page !== 1 ? {
                    page: page,
                    ...this.query
                } : this.query
            }));
            this.page = page;
        }
    }
}
