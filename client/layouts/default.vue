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
import layout from '@/mixins/layout';
import echo from '@/mixins/echo';
export default{
    mixins: [
        layout,
        echo
    ],
    components: {
        CustomNuxt,
        CustomHeader,
        CustomFooter,
        Sidebar
    }
}
</script>
