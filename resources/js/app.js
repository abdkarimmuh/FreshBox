require('./bootstrap');

window.Vue = require('vue');

import iosAlertView from 'vue-ios-alertview';
import Router from './router.js';

Vue.use(iosAlertView);

import DatePicker from 'vue2-datepicker';
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
Vue.use(DatePicker);


axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

const app = new Vue({
    el: '#app',
    router: Router,
    data() {
        return {
            user: AuthUser,
            lang: {
                type:'en',
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
                placeholder: {
                    date: 'Select Date',
                    dateRange: 'Select Date Range'
                }
            },
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
