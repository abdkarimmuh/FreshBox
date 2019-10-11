/**
 * List Component
 */
// import DataTable from "./components/DataTable/DataTable";
import UsersComponent from './components/UsersComponent';
import ProfileComponent from './components/ProfileComponent';
import AdduserComponent from './components/AdduserComponent';

import ConfirmDeliveryOrder from './components/Warehouse/ConfirmDeliveryOrder';
import StislaFromInput from './components/Template/Etc/s-form-input';

import Table from "./components/Template/Table";
import Pagination from "./components/Template/Pagination";
import Testing from "./components/Testing";
import ErrorPage from "./components/Template/ErrorPage";
import ConfirmButton from "./components/Template/ConfirmButton";
import HeaderPrint from "./components/Template/Print/HeaderPrint";
import HeaderInfoPrint from "./components/Template/Print/HeaderInfoPrint";

import TablePrint from "./components/Template/Print/TablePrint";


Vue.component('users-component', UsersComponent);
Vue.component('profile-component', ProfileComponent);
Vue.component('adduser-component', AdduserComponent);

// Vue.component('add-sales-order', AddSalesOrder);
// Vue.component('edit-sales-order', EditSalesOrder);
// Vue.component('add-delivery-order', AddDeliveryOrder);
// Vue.component('add-invoice', AddInvoice);

Vue.component('confirm-delivery-order', ConfirmDeliveryOrder);

// Vue.component('multiple-print-sales-order', MultiplePrintSalesOrder);
// Vue.component('multiple-print-delivery-order', MultiplePrintDeliveryOrder);
// Vue.component('multiple-print-invoice-order', MultiplePrintInvoiceOrder);

// Vue.component('print-sales-order', PrintSalesOrder);
// Vue.component('print-delivery-order', PrintDeliveryOrder);
// Vue.component('print-invoice-order', PrintInvoiceOrder);

// Vue.component('print-recap-invoice', PrintRecapInvoice);
Vue.component('print-header', HeaderPrint);
Vue.component('print-header-info', HeaderInfoPrint);

Vue.component('print-table', TablePrint);

Vue.component('s-form-input', StislaFromInput);
Vue.component('s-table', Table);
Vue.component('s-pagination', Pagination);
Vue.component('s-testing', Testing);
Vue.component('s-error-page', ErrorPage);
Vue.component('s-btn-confirm', ConfirmButton);

// Vue.component("data-table", DataTable);
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
