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
import AddSalesOrder from "./components/Marketing/SalesOrder/AddSalesOrder";
import EditSalesOrder from "./components/Marketing/SalesOrder/EditSalesOrder";
import VueSweetalert2 from 'vue-sweetalert2';
import AddDeliveryOrder from './components/Warehouse/AddDeliveryOrder';

Vue.use(VueSweetalert2);
Vue.component('vue-headful', vueHeadful);
Vue.component('users-component', UsersComponent);
Vue.component('profile-component', ProfileComponent);
Vue.component('adduser-component', AdduserComponent);
Vue.component('addsalesorder-component', AddSalesOrder);
Vue.component('editsalesorder-component', EditSalesOrder);

Vue.component('add_deliver_order-component', AddDeliveryOrder);
// Vue.component('editsalesorder-component', EditSalesOrder);

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
