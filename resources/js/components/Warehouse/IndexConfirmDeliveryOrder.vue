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
                    title: 'Form Delivery Order',
                    action: true,
                    base_url: this.$parent.MakeUrl('api/v1/warehouse/delivery_order'),
                    // route_search: 'admin.marketing.sales_order.index',
                    route_create: 'delivery_order.create',
                    route_view: 'delivery_order.print',
                    route_multiple_print: 'delivery_order.multiplePrint',
                },
                      $columns = [
            array('title' => 'Delivery Order No', 'field' => 'delivery_order_no'),
            array('title' => 'Customer', 'field' => 'customer_name'),
            array('title' => 'Do Date', 'field' => 'do_date'),
            array('title' => 'Remarks', 'field' => 'remarks'),
            array('title' => 'Driver', 'field' => 'driver_name'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
        ];

                columns: [
                    {
                        title: 'Delivery Order No',
                        field: 'delivery_order_no',
                        filterable: true,
                    },
                    {
                        title: 'Sales Order NO',
                        field: 'sales_order_no',
                        filterable: true,
                    },
                    {
                        title: 'Customer',
                        field: 'customer_name',
                        filterable: true,
                    },
                    {
                        title: 'PIC QC',
                        field: 'pic_qc',
                        filterable: false,
                    },
                    {
                        title: 'Driver',
                        field: 'driver_name',
                        filterable: true,
                    },
                    {
                        title: 'DO Date',
                        field: 'do_date',
                        filterable: true,
                    },
                    {
                        title: 'Remarks',
                        field: 'remarks',
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
