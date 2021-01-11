<template>
    <main>
        <h1 class="capitalize">
            {{ $t('account ')}}
        </h1>
        <ul>
            <li>
                <nuxt-link :to="generateRoute({name: 'account-social'})">
                    {{ $t('social_account') }}
                </nuxt-link>
            </li>
        </ul>
    </main>
</template>
<script type="text/javascript">
export default{
    head(){
        return {
            title: this.$t('account').toCapitalizePhrases()
        }
    },
    middleware: 'auth'
}
</script>
