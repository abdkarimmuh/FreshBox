/**
 * List Library Library
 */
import vueHeadful from 'vue-headful';
import DatePicker from 'vue2-datepicker';
import iosAlertView from 'vue-ios-alertview';
import VueSweetalert2 from 'vue-sweetalert2';
import VueHtmlToPaper from 'vue-html-to-paper';
import ModelListSelect from 'vue-search-select';
import 'vue-search-select/dist/VueSearchSelect.css'
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
Vue.component('model-list-select', ModelListSelect);

Vue.component("laravel-pagination", require('laravel-vue-pagination'));
