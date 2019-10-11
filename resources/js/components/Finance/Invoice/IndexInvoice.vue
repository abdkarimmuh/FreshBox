<template>
    <div v-if="$parent.userRole('Admin')">
        <s-table :config="config" :columns="columns"></s-table>
    </div>
    <div v-else>
        <s-error-page :error="error"></s-error-page>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                config: {
                    title: 'Form Invoice Order',
                    action: true,
                    base_url: this.$parent.MakeUrl('api/v1/finance/invoice_order'),
                    route_create: 'invoice_order.create',
                    route_view: 'invoice_order.print',
                    route_edit: 'invoice_order.edit',
                    route_multiple_print: 'invoice_order.multiplePrint',
                    route_print_rekap: 'invoice_order.multiplePrint'
                },
                columns: [
                    {
                        title: 'Invoice Order NO',
                        field: 'invoice_no',
                        filterable: true,
                    },
                    {
                        title: 'Delivery Order No',
                        field: 'delivery_order_no',
                        filterable: true,
                    },
                    {
                        title: 'Sales Order No',
                        field: 'sales_order_no',
                        filterable: true,
                    },
                    {
                        title: 'Customer Name',
                        field: 'customer_name',
                        filterable: false,
                    },
                    {
                        title: 'Invoice Date',
                        field: 'invoice_date',
                        filterable: true,
                    },
                    {
                        title: 'Total Amount',
                        field: 'total_price',
                        type: 'price',
                        filterable: true,
                    },
                    {
                        title: 'Status',
                        field: 'status_name',
                        type: 'html',
                        filterable: true,
                    },
                    {
                        title: 'Created At',
                        field: 'created_at',
                        filterable: true,
                    },
                    {
                        title: 'Created By',
                        field: 'created_by_name',
                        filterable: true,
                    },
                ],
                error: {
                    code: 403,
                    description: 'You do not have access to this page'
                }
            }
        },
    }
</script>
