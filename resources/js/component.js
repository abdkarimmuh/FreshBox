/**
 * List Component
 */
import UsersComponent from './components/UsersComponent';
import ProfileComponent from './components/ProfileComponent';
import AdduserComponent from './components/AdduserComponent';
// import DataTable from "./components/DataTable/DataTable";
import AddSalesOrder from "./components/Marketing/SalesOrder/AddSalesOrder";
import EditSalesOrder from "./components/Marketing/SalesOrder/EditSalesOrder";
import AddDeliveryOrder from './components/Warehouse/AddDeliveryOrder';
import PDFComponent from './components/Template/PDFComponent';
import StislaFromInput from './components/Template/Etc/s-form-input';

Vue.component('users-component', UsersComponent);
Vue.component('profile-component', ProfileComponent);
Vue.component('adduser-component', AdduserComponent);
Vue.component('addsalesorder-component', AddSalesOrder);
Vue.component('editsalesorder-component', EditSalesOrder);
Vue.component('adddelieryorder-component', AddDeliveryOrder);
Vue.component('pdf-component', PDFComponent);
Vue.component('s-form-input', StislaFromInput);

// Vue.component("data-table", DataTable);
