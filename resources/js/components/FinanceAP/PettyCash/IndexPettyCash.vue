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
                    route_view: "finance.pettyCash.show",
                    // route_multiple_print: 'invoice_order.multiplePrint',
                },
                columns: [
                    {
                        title: "Status",
                        field: "status_name",
                        filterable: true,
                        type: "html"
                    },
                    {
                        title: "User Request Name",
                        field: "user_request_name",
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
                ],
                error: {
                    code: 403,
                    description: "You do not have access to this page"
                }
            };
        }
    };
</script>
