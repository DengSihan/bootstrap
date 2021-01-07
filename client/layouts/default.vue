<template>
    <fragment>
        <header>
            <nuxt-link :to="generateRoute({name: 'index'})">index</nuxt-link>
        </header>
        <transition
            mode="out-in"
            :name="transitionName"
            @beforeLeave="beforeLeave"
            @enter="enter"
            @afterEnter="afterEnter">
            <router-view v-if="!nuxt.err"/>
            <error-view :error="nuxt.err" v-else/>
        </transition>
        <footer class="border-t-4 border-0 border-solid border-gray-900">
            <i>footer</i>
        </footer>
    </fragment>
</template>
<script type="text/javascript">
import Vue from 'vue';
import ErrorView from '@/layouts/error';
export default{
    components: {
        ErrorView
    },
    data() {
        return {
            prevHeight: 0,
            transitionName: 'fade'
        };
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
    },
    methods: {
        beforeLeave(el) {
            this.prevHeight = getComputedStyle(el).height;
        },
        enter(el) {
            const { height } = getComputedStyle(el);
            el.style.height = this.prevHeight;
            setTimeout(() => {
                el.style.height = height;
            }, 0);
        },
        afterEnter(el) {
            el.style.height = 'auto';
        }
    }
}
</script>
