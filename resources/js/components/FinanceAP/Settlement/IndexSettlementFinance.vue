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
                title: "Settlement Cash Advance",
                action: true,
                base_url: this.$parent.MakeUrl(
                    "api/v1/finance-ap/request-advance/settlement"
                ),
                route_settlement: "finance.settlementFinance.settlement",
                route_view_settlement: "finance.settlementFinance.show",
                // route_create: "finance.requestFinance.create"
                // route_multiple_print: 'invoice_order.multiplePrint',
            },
            columns: [
                {
                    title: "No Request",
                    field: "no_request",
                    filterable: true
                },
                {
                    title: "Request Date",
                    field: "request_date",
                    filterable: true
                },
                {
                    title: "User Name",
                    field: "user_name",
                    filterable: false
                },
                {
                    title: "Shipping Address",
                    field: "shipping_address",
                    filterable: true
                },
                {
                    title: "Dept",
                    field: "dept",
                    filterable: true
                },
                // {
                //     title: 'Status',
                //     field: 'status_name',
                //     type: 'html',
                // },
                {
                    title: "Created At",
                    field: "created_at",
                    filterable: true
                },
                {
                    title: "Created By",
                    field: "created_by_name",
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
