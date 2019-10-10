window.Vue = require('vue');

require('./bootstrap');
require('./component');
require('./library');
require('./filters');

import router from './router';
import store from './store'

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'Authorization': 'Bearer ' + AccessToken
};

const app = new Vue({
    el: '#app',
    router,
    store,
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
        userRole(role) {
            if (this.user && this.user.all_roles.includes(role)) {
                return true;
            }
            return false;
        },
        MakeUrl(path) {
            return BaseUrl(path);
        }
    },
    filters: {
        /**
         * Formatting Price Number
         * @param value
         * @returns {string}
         */
        price: function (value) {
            if (!value) return '';
            return value.toLocaleString("id-ID", {
                minimumFractionDigits: 2
            });
        },
    }
});
