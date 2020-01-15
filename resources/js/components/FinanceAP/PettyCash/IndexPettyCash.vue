<template>
    <div v-if="$parent.userRole('Admin')">
        <s-table :config="config" :columns="columns"/>
    </div>
    <div v-else>
        <s-error-page :error="error"/>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                config: {
                    title: "Petty Cash",
                    action: true,
                    base_url: this.$parent.MakeUrl("api/v1/finance-ap/petty-cash"),
                    route_view: "finance.requestFinance.show",
                    // route_multiple_print: 'invoice_order.multiplePrint',
                },
                columns: [
                    {
                        title: "Status",
                        field: "status",
                        filterable: true,
                        type: "html"
                    },
                    {
                        title: "Vendor Name",
                        field: "vendor_name",
                        filterable: true
                    },
                    {
                        title: "Amount",
                        field: "amount",
                        filterable: false
                    },

                    {
                        title: "Created At",
                        field: "created_at",
                        filterable: true
                    }
                    // {
                    //     title: "Created By",
                    //     field: "created_by_name",
                    //     filterable: true
                    // }
                ],
                error: {
                    code: 403,
                    description: "You do not have access to this page"
                }
            };
        }
    };
</script>
