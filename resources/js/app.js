require('./bootstrap');

window.Vue = require('vue');

/**
 * Library
 */
import vueHeadful from 'vue-headful';
import DatePicker from 'vue2-datepicker';
import iosAlertView from 'vue-ios-alertview';
import VueSweetalert2 from 'vue-sweetalert2';
import VueHtmlToPaper from 'vue-html-to-paper';
import Router from './router';

const options = {
    name: '_blank',
    specs: [
        'fullscreen=yes',
        'titlebar=yes',
        'scrollbars=yes'
    ],
    styles: [
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    ]
}

Vue.use(VueSweetalert2);
Vue.use(VueHtmlToPaper, options);
Vue.use(iosAlertView);
Vue.use(DatePicker);
Vue.component('vue-headful', vueHeadful);
Vue.component("laravel-pagination", require('laravel-vue-pagination'));

/**
 * Component
 */
import UsersComponent from './components/UsersComponent';
import ProfileComponent from './components/ProfileComponent';
import AdduserComponent from './components/AdduserComponent';
import DataTable from "./components/DataTable/DataTable";
import AddSalesOrder from "./components/Marketing/SalesOrder/AddSalesOrder";
import EditSalesOrder from "./components/Marketing/SalesOrder/EditSalesOrder";
import AddDeliveryOrder from './components/Warehouse/AddDeliveryOrder';
import PDFComponent from './components/Template/PDFComponent';

Vue.component('users-component', UsersComponent);
Vue.component('profile-component', ProfileComponent);
Vue.component('adduser-component', AdduserComponent);
Vue.component('addsalesorder-component', AddSalesOrder);
Vue.component('editsalesorder-component', EditSalesOrder);
Vue.component('adddelieryorder-component', AddDeliveryOrder);
Vue.component('pdf-component', PDFComponent);
Vue.component("data-table", DataTable);

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
