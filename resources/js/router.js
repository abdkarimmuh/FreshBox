import Vue from 'vue'
import VueRouter from 'vue-router';
import UsersComponent from './components/UsersComponent';
import AdduserComponent from './components/AdduserComponent';

import FormSalesOrder from './components/Marketing/SalesOrder/IndexSalesOrder';
import AddSalesOrder from "./components/Marketing/SalesOrder/AddSalesOrder";
import EditSalesOrder from "./components/Marketing/SalesOrder/EditSalesOrder";
import PrintSalesOrder from "./components/Marketing/SalesOrder/PrintSalesOrder";
import MultiplePrintSalesOrder from "./components/Marketing/SalesOrder/MultiplePrintSalesOrder";


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        /**
         * Sales Order
         */
        // Index
        {
            path: '/admin/marketing/form_sales_order',
            name: "form_sales_order",
            component: FormSalesOrder
        },
        // Print Sales Order
        {
            path: '/admin/marketing/form_sales_order/:id/print',
            name: "form_sales_order.print",
            component: PrintSalesOrder
        },
        // Print Multiple Sales Order
        {
            path: '/admin/marketing/form_sales_order/printMultiple/',
            name: "form_sales_order.multiplePrint",
            component: MultiplePrintSalesOrder,
            props: true
        },
        // Create Sales Order
        {
            path: '/admin/marketing/form_sales_order/create',
            name: "form_sales_order.create",
            component: AddSalesOrder
        },
        {
            path: '/admin/marketing/form_sales_order/:id/edit',
            name: "form_sales_order.edit",
            component: EditSalesOrder
        },
        /**
         * Warehouse
         */
        {
            path: '/admin/users',
            name: 'users',
            component: UsersComponent
        },
        {
            path: '/admin/users/adduser',
            name: 'adduser',
            component: AdduserComponent
        },

    ],
});

export default router;
