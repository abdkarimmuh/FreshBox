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
                    "api/v1/finance-ap/settlement-cash-advance"
                ),
                noStartEnd: true,
                route_add: "/admin/finance-ap/settlement-cash-advance/create",
                route_view: "finance.settlementFinance.show"
            },
            columns: [
                {
                    title: "No Settlement",
                    field: "no_settlement",
                    filterable: true
                },
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
                    title: "Status",
                    field: "status_name",
                    type: "html"
                },
                {
                    title: "Requester Name",
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
