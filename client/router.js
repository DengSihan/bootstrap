import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const page = path => () => import(`~/pages/${path}`).then(m => m.default || m);

const routes = [
    {
        path: '/login',
        name: 'login',
        component: page('login.vue')
    },
    {
        path: '/register',
        name: 'register',
        component: page('register.vue')
    },
    {
        path: '/',
        name: 'index',
        component: page('index.vue')
    }
];

const defaultMeta = {
    transitionName: 'slide'
};

routes.forEach(route => {
    route.meta = route.meta ? route.meta : defaultMeta;
});

export function createRouter(){
    return new VueRouter({
        routes,
        mode: 'history'
    });
}
