/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import App from './App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import {routes} from './routes';
import Vuex from 'vuex'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('main-page', require('./components/MainPageComponent.vue').default);
Vue.component('nav-bar', require('./components/NavBarComponent.vue').default);
Vue.component('statuses-index', require('./components/StatusesIndex.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.use(VueRouter);
Vue.use(VueAxios, axios);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const store = new Vuex.Store({
    state: {
        api_token: localStorage.getItem('api_token') || undefined,
        isadmin: false,
        isauth: false,

    },
    getters: {
        TOKEN: state => {
            return state.api_token;
        },
        ISADMIN: state => {
            return state.isadmin;
        },
        ISAUTH: state => {
            return state.isauth;
        }
    },

    mutations: {

        SET_TOKEN: (state, payload) => {

            state.api_token = payload;
        },
        SET_ISADMIN: (state, payload) => {
            state.isadmin = payload;
        },
        SET_ISAUTH: (state, payload) => {
            state.isauth = payload;
        }
    }
})


Vue.mixin({
    methods: {
        loadUserInfo: function (token) {

            var app = this;
            console.log("token is " + token);
            axios.defaults.headers.common['Authorization'] = `Bearer ` + token;
            axios.get('/api/user')
                .then(function (resp) {
                    app.$store.commit('SET_ISAUTH', true);

                    if (resp.data.isadmin == 1) {

                        app.$store.commit('SET_ISADMIN', true);
                    } else {
                        app.$store.commit('SET_ISADMIN', false);
                    }
                    app.$root.$emit('update_user_info', app.$store.getters.ISAUTH, app.$store.getters.ISADMIN);

                })
                .catch(function () {
                    if (app.$router.currentRoute.name != "auth.login") {
                        app.$router.replace('/login');
                    }
                });
        }
    }
});



const app = new Vue({
    el: '#app',
    router: router,
    store: store,

    render: h => h(App),
});
// const app = new Vue({
//     el: '#app',
// });


