/**
 * List Component
 */
// import DataTable from "./components/DataTable/DataTable";
import UsersComponent from './components/UsersComponent';
import ProfileComponent from './components/ProfileComponent';
import AdduserComponent from './components/AdduserComponent';

import ConfirmDeliveryOrder from './components/Warehouse/ConfirmDeliveryOrder';
import StislaFromInput from './components/Template/Etc/s-form-input';

import Table from "./components/Template/Table/Table";
import Testing from "./components/Testing";
import ErrorPage from "./components/Template/ErrorPage";
import ConfirmButton from "./components/Template/ConfirmButton";
import HeaderPrint from "./components/Template/Print/HeaderPrint";
import HeaderInfoPrint from "./components/Template/Print/HeaderInfoPrint";

import TablePrint from "./components/Template/Print/TablePrint";
import IndexReportSO from "./components/Report/SO/IndexReportSO"
import AddUserProc from "./components/MasterData/AddUserProc"

Vue.component('index-report-so', IndexReportSO);

Vue.component('users-component', UsersComponent);
Vue.component('profile-component', ProfileComponent);
Vue.component('adduser-component', AdduserComponent);


Vue.component('confirm-delivery-order', ConfirmDeliveryOrder);

Vue.component('print-header', HeaderPrint);
Vue.component('print-header-info', HeaderInfoPrint);

Vue.component('print-table', TablePrint);

Vue.component('s-form-input', StislaFromInput);
Vue.component('s-table', Table);
Vue.component('s-testing', Testing);
Vue.component('s-error-page', ErrorPage);
Vue.component('s-btn-confirm', ConfirmButton);

Vue.component('AddUserProc', AddUserProc);

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
