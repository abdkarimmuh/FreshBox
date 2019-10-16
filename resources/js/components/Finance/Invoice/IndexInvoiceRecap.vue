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
                    title: 'Recap Invoice Order',
                    action: true,
                    base_url: this.$parent.MakeUrl('api/v1/finance/invoice_recap'),
                    // route_create: 'invoice_order.create',
                    route_view: 'invoice_order.recap.show',
                    route_edit: 'invoice_order.edit',
                    // route_multiple_print: 'invoice_order.multiplePrint',
                },
                columns: [
                    {
                        title: 'Recap Invoice NO',
                        field: 'recap_invoice_no',
                        filterable: true,
                    },
                    {
                        title: 'Customer Name',
                        field: 'customer_name',
                        filterable: false,
                    },
                    {
                        title: 'Recap Date',
                        field: 'recap_date',
                        filterable: true,
                    },
                    {
                        title: 'Total Amount',
                        field: 'total_amount',
                        type: 'price',
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
