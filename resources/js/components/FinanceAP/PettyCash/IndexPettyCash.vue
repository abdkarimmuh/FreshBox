<template>
    <div v-if="$parent.userRole('Admin')">
        <s-table :config="config" :columns="columns" />
    </div>
    <div v-else>
        <s-error-page :error="error" />
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
                noStartEnd: true,
                route_view: "finance.pettyCash.show"
                // route_multiple_print: 'invoice_order.multiplePrint',
            },
            columns: [
                {
                    title: "No Transaksi",
                    field: "no_trx"
                },
                {
                    title: "Status",
                    field: "status_name",
                    type: "html"
                },
                {
                    title: "User Request Name",
                    field: "user_request_name"
                },
                {
                    title: "Amount",
                    field: "amount"
                },
                {
                    title: "Created At",
                    field: "created_at"
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
