import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const page = path => () => import(`~/pages/${path}.vue`).then(m => m.default || m);

const routes = [
    {
        path: '/account',
        name: 'account',
        component: page('account/index')
    },
    {
        path: '/account/update-password',
        name: 'account/update-password',
        component: page('account/update-password')
    },
    {
        path: '/account/social',
        name: 'account/social',
        component: page('account/social')
    },
    {
        path: '/logout',
        name: 'logout',
        component: page('logout')
    },
    {
        path: '/login',
        name: 'login',
        component: page('login')
    },
    {
        path: '/social-login/:social',
        name: 'social-login/social',
        component: page('social-login')
    },
    {
        path: '/social-certificate/:certificate',
        name: 'social-certificate/certificate',
        component: page('social-certificate')
    },
    {
        path: '/register',
        name: 'register',
        component: page('register')
    },
    {
        path: '/forget-password',
        name: 'forget-password',
        component: page('forget-password')
    },
    {
        path: '/',
        name: 'index',
        component: page('index')
    }
];

const defaultMeta = {
    transitionName: 'slide'
};

routes.forEach(route => {
    route.meta = route.meta ? route.meta : defaultMeta;
    if (!route.path.startsWith(`/:locale?`) && !route.path.startsWith(`/admin`)) {
        route.path = `/:locale?${route.path}`;
        route.props = true;
    }
});

export function createRouter(){
    return new VueRouter({
        routes,
        mode: 'history'
    });
}
