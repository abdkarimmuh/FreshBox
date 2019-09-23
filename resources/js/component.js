/**
 * List Component
 */
// import DataTable from "./components/DataTable/DataTable";

import UsersComponent from './components/UsersComponent';
import ProfileComponent from './components/ProfileComponent';
import AdduserComponent from './components/AdduserComponent';
import AddSalesOrder from "./components/Marketing/SalesOrder/AddSalesOrder";
import EditSalesOrder from "./components/Marketing/SalesOrder/EditSalesOrder";
import AddDeliveryOrder from './components/Warehouse/AddDeliveryOrder';
import ConfirmDeliveryOrder from './components/Warehouse/ConfirmDeliveryOrder';
import PDFComponent from './components/Template/PDFComponent';
import StislaFromInput from './components/Template/Etc/s-form-input';
import AddInvoice from './components/Finance/Invoice/AddInvoice';

Vue.component('users-component', UsersComponent);
Vue.component('profile-component', ProfileComponent);
Vue.component('adduser-component', AdduserComponent);
Vue.component('addsalesorder-component', AddSalesOrder);
Vue.component('editsalesorder-component', EditSalesOrder);
Vue.component('adddelieryorder-component', AddDeliveryOrder);
Vue.component('add-invoice', AddInvoice);

Vue.component('confirm_delivery_order-component', ConfirmDeliveryOrder);

Vue.component('pdf-component', PDFComponent);
Vue.component('s-form-input', StislaFromInput);

// Vue.component("data-table", DataTable);
