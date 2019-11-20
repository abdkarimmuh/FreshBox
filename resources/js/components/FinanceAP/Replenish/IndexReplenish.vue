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
                    title: 'Finance Replenish',
                    action: true,
                    base_url: this.$parent.MakeUrl('api/v1/finance-ap/replenish'),
                    route_view: 'invoice_order.recap.show',
                    // route_multiple_print: 'invoice_order.multiplePrint',
                },
                columns: [
                    {
                        title: 'Procurement No',
                        field: 'recap_invoice_no',
                        filterable: true,
                    },
                    {
                        title: 'User Procurement',
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
