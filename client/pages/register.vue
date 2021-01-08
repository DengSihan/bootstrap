<template>
    <main>
        <h1 class="capitalize">
            {{ $t('register') }}
        </h1>
    </main>
</template>
<script type="text/javascript">
import auth from '@/mixins/auth';
export default{
    head(){
        return {
            title: this.$t('register').toCapitalizePhrases()
        }
    },
    mixins: [
        auth
    ]
}
</script>
