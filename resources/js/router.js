import Vue from 'vue'
import VueRouter from 'vue-router';
import UsersComponent from './components/UsersComponent';
import ProfileComponent from './components/ProfileComponent';
import AdduserComponent from './components/AdduserComponent';
import FormSalesOrder from './components/marketing/FormSalesOrderComponent';
import Testing from "./components/Testing";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
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
        {
            path: '/admin/marketing/form_sales_order',
            name: 'form_sales_order',
            meta: {title: 'Home'},
            component: FormSalesOrder
        },
        {
            path: '/admin/marketing/form_sales_order/:id/view',
            name: 'viewSalesOrder',
            component: FormSalesOrder
        },
        {
            path: '/admin/marketing/form_sales_order/:id/edit',
            name: 'editSalesOrder',
            component: FormSalesOrder
        },
        {
            path: '/admin/testing',
            name: 'testing',
            component: Testing
        }
    ],
});

export default router;
