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
                title: "Request Cash Advance",
                action: true,
                base_url: this.$parent.MakeUrl(
                    "api/v1/finance-ap/request-advance"
                ),
                noStartEnd: true,
                route_view: "finance.requestAdvance.show",
                route_create: "finance.requestAdvance.create",
                route_edit_payment: "finance.requestAdvance.edit",
                route_upload_payment: "finance.requestAdvance.upload"
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
                {
                    title: "Status",
                    field: "status_name",
                    type: "html"
                },
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
