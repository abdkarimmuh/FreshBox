<template>
    <div>
        <s-table :config="config" :columns="columns"></s-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                config: {
                    title: 'Form Sales Order',
                    base_url: 'form_sales_order',
                    route_search: 'admin.marketing.sales_order.index',
                    route_add: 'form_sales_order/create',
                    route_edit: 'admin.marketing.sales_order.edit',
                    route_view: 'form_sales_order/',
                    url_multiple_print: 'form_sales_order/multiplePrint',
                },
                perPage: ['10', '25', '50'],
                columns: [
                    {
                        label: 'Custname',
                        field: 'customer_name',
                        filterable: true,
                    },
                    {
                        label: 'Source Order',
                        field: 'source_order_name',
                        filterable: true,
                    },
                    {
                        label: 'Remarks',
                        field: 'remarks',
                        filterable: true,
                    },
                    {
                        label: 'Fulfillment Date',
                        field: 'fulfillment_date',
                        filterable: true,
                    }
                ],
            }
        },
    }
</script>
