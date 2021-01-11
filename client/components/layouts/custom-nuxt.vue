<template>
    <main>
        <transition
            mode="out-in"
            :name="transitionName"
            @beforeLeave="beforeLeave"
            @enter="enter"
            @afterEnter="afterEnter">
            <router-view v-if="!nuxt.err"/>
            <error-view :error="nuxt.err" v-else/>
        </transition>
    </main>
</template>
<script type="text/javascript">
import Vue from 'vue';
import ErrorView from '@/layouts/error';
import transition from '@/mixins/transition';
export default{
    mixins: [
        transition
    ],
    components: {
        ErrorView
    },
    beforeCreate () {
        Vue.util.defineReactive(this, 'nuxt', this.$root.$options.nuxt);
    },
    created() {
        this.$router.beforeEach((to, from, next) => {
            let transitionName = to.meta.transitionName || from.meta.transitionName;
            if (transitionName === 'slide') {
                const toDepth = to.path.split('/').length;
                const fromDepth = from.path.split('/').length;
                transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left';
            }
            this.transitionName = transitionName || 'fade';
            next();
        });
    }
}
</script>
