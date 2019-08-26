require('./bootstrap');

window.Vue = require('vue');

import iosAlertView from 'vue-ios-alertview';
import Router from './router.js';
Vue.use(iosAlertView);

import vueHeadful from 'vue-headful';
import UsersComponent from './components/UsersComponent';
import ProfileComponent from './components/ProfileComponent';
import AdduserComponent from './components/AdduserComponent';
import DataTable from "./components/DataTable/DataTable";

Vue.component('vue-headful', vueHeadful);
Vue.component('users-component', UsersComponent);
Vue.component('profile-component', ProfileComponent);
Vue.component('adduser-component', AdduserComponent);
Vue.component("data-table", DataTable);
Vue.component("laravel-pagination", require('laravel-vue-pagination'));



axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

const app = new Vue({
    el: '#app',
    router: Router,
    data() {
        return {
            user: AuthUser
        }
    },
    methods: {
        userCan(permission) {
            if (this.user && this.user.allPermissions.includes(permission)) {
                return true;
            }
            return false;
        },
        MakeUrl(path) {
            return BaseUrl(path);
        }
    }
});
