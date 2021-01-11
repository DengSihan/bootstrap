<template>
    <fragment>
        <custom-header/>
        <sidebar/>
        <custom-nuxt/>
        <custom-footer/>
    </fragment>
</template>
<script type="text/javascript">
import CustomNuxt from '@/components/layouts/custom-nuxt';
import CustomHeader from '@/components/layouts/custom-header';
import CustomFooter from '@/components/layouts/custom-footer';
import Sidebar from '@/components/layouts/sidebar';
export default{
    head(){
        return {
            htmlAttrs: {
                lang: this.$store.state.locale.locale
            }
        }
    },
    components: {
        CustomNuxt,
        CustomHeader,
        CustomFooter,
        Sidebar
    }
}
</script>
