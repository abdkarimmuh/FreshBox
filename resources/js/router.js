import Vue from 'vue'
import VueRouter from 'vue-router';
import UsersComponent from './components/UsersComponent';
import AdduserComponent from './components/AdduserComponent';

import FormSalesOrder from './components/Marketing/SalesOrder/IndexSalesOrder';
import AddSalesOrder from "./components/Marketing/SalesOrder/AddSalesOrder";
import EditSalesOrder from "./components/Marketing/SalesOrder/EditSalesOrder";
import PrintSalesOrder from "./components/Marketing/SalesOrder/PrintSalesOrder";
import MultiplePrintSalesOrder from "./components/Marketing/SalesOrder/MultiplePrintSalesOrder";

import IndexInvoice from './components/Finance/Invoice/IndexInvoice';
import PrintInvoice from './components/Finance/Invoice/PrintInvoiceOrder';
import AddInvoice from './components/Finance/Invoice/AddInvoice';


import IndexInvoiceRecap from './components/Finance/Invoice/IndexInvoiceRecap';
import MultiplePrintInvoiceOrder from './components/Finance/Invoice/MultiplePrintInvoiceOrder';
import PrintAllInvoice from './components/Finance/Invoice/PrintAllInvoice';

import PrintRecapInvoice from './components/Finance/Invoice/PrintRecapInvoice';
import IndexSubmittedRecap from './components/Finance/Invoice/IndexSubmittedRecap';
import SubmitRecapInvoice from './components/Finance/Invoice/SubmitRecapInvoice';

import IndexPaidRecap from './components/Finance/Invoice/IndexPaidRecap';
import AddPaidInvoice from './components/Finance/Invoice/AddPaidInvoice';

import IndexDeliveryOrder from './components/Warehouse/IndexDeliveryOrder';
import AddDeliveryOrder from './components/Warehouse/AddDeliveryOrder';
import PrintDeliveryOrder from "./components/Warehouse/PrintDeliveryOrder";
import MultiplePrintDeliveryOrder from "./components/Warehouse/MultiplePrintDeliveryOrder";

import IndexConfirmDeliveryOrder from './components/Warehouse/IndexConfirmDeliveryOrder';
import AddConfirmDeliveryOrder from './components/Warehouse/ConfirmDeliveryOrder';

import ImportPriceTemp from "./components/ImportExcel/ImportPriceTemp";

import AddFinanceReplenish from './components/FinanceAP/Replenish/AddReplenish';
import IndexReplenish from './components/FinanceAP/Replenish/IndexReplenish';

Vue.component('import-price-temp', ImportPriceTemp);
Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/admin/import/price',
            name: "import.price",
            component: ImportPriceTemp
        },
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
         * Invoice Order
         */
        // Index
        {
            path: '/admin/finance/invoice-order',
            name: "invoice_order",
            component: IndexInvoice
        },
        // Print Sales Order
        {
            path: '/admin/finance/invoice-order/:id/print',
            name: "invoice_order.print",
            component: PrintInvoice
        },
        // Print Multiple Sales Order
        {
            path: '/admin/finance/invoice-order/print-multiple/',
            name: "invoice_order.multiplePrint",
            component: MultiplePrintInvoiceOrder,
            props: true
        },
        // Print All
        {
            path: '/admin/finance/invoice-order/print-all/',
            name: "invoice_order.printAll",
            component: PrintAllInvoice,
        },
        // Create Sales Order
        {
            path: '/admin/finance/invoice-order/create',
            name: "invoice_order.create",
            component: AddInvoice
        },
        //Submit Recap Invoice
        {
            path: '/admin/finance/submitted-recap',
            name: "submitRecap",
            component: IndexSubmittedRecap
        },
        //Create Submit Recap Invoice
        {
            path: '/admin/finance/submitted-recap/create',
            name: "submitRecap.create",
            component: SubmitRecapInvoice
        },
        //Index Paid Recap
        {
            path: '/admin/finance/paid-recap',
            name: "paidRecap",
            component: IndexPaidRecap
        },
        //Add Paid Recap Invoice
        {
            path: '/admin/finance/paid-recap/create',
            name: "paidRecap.create",
            component: AddPaidInvoice
        },
        {
            path: '/admin/finance/recap-invoice',
            name: "invoice_order.recap",
            component: IndexInvoiceRecap
        },
        {
            path: '/admin/finance/recap-invoice/show/:id',
            name: "invoice_order.recap.show",
            component: PrintRecapInvoice
        },

        /**
         * Warehouse
         */
        {
            path: '/admin/warehouse/delivery-order',
            name: 'delivery_order.index',
            component: IndexDeliveryOrder
        },
        {
            path: '/admin/warehouse/delivery-order/create',
            name: 'delivery_order.create',
            component: AddDeliveryOrder
        },
        {
            path: '/admin/warehouse/delivery-order/:id/print',
            name: 'delivery_order.print',
            component: PrintDeliveryOrder
        },
        {
            path: '/admin/warehouse/delivery-order/multiplePrint',
            name: 'delivery_order.multiplePrint',
            component: MultiplePrintDeliveryOrder
        },
        //Confirm Delivery Order
        {
            path: '/admin/warehouse/confirm-delivery-order',
            name: 'confirm_delivery_order',
            component: IndexConfirmDeliveryOrder
        },
        {
            path: '/admin/warehouse/confirm-delivery-order/create/:id',
            name: 'confirm_delivery_order.create',
            component: AddConfirmDeliveryOrder
        },

        //Finance AP Replenish
        {
            path: '/admin/finance-ap/replenish',
            name: 'finance.replenish',
            component: IndexReplenish
        },
        {
            path: '/admin/finance-ap/replenish/create',
            name: 'finance.replenish.create',
            component: AddFinanceReplenish
        },

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
