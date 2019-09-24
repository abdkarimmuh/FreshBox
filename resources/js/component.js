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
import StislaFromInput from './components/Template/Etc/s-form-input';
import AddInvoice from './components/Finance/Invoice/AddInvoice';
import PrintSalesOrder from './components/Template/PrintSalesOrder';
import PrintDeliveryOrder from "./components/Template/PrintDeliveryOrder";
import PrintInvoiceOrder from "./components/Template/PrintInvoiceOrder";
import MultiplePrintSalesOrder from "./components/Template/MultiplePrintSalesOrder";

Vue.component('users-component', UsersComponent);
Vue.component('profile-component', ProfileComponent);
Vue.component('adduser-component', AdduserComponent);

Vue.component('add-sales-order', AddSalesOrder);
Vue.component('edit-sales-order', EditSalesOrder);
Vue.component('add-delivery-order', AddDeliveryOrder);
Vue.component('add-invoice', AddInvoice);
Vue.component('confirm-delivery-order', ConfirmDeliveryOrder);

Vue.component('multiple-print-sales-order', MultiplePrintSalesOrder);
Vue.component('print-sales-order', PrintSalesOrder);
Vue.component('print-delivery-order', PrintDeliveryOrder);
Vue.component('print-invoice-order', PrintInvoiceOrder);

Vue.component('s-form-input', StislaFromInput);

// Vue.component("data-table", DataTable);
