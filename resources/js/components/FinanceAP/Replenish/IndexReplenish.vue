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
                title: "Finance Replenish",
                action: true,
                noStartEnd: true,
                base_url: this.$parent.MakeUrl("api/v1/finance-ap/replenish"),
                route_replenish: "finance.replenish.replenish",
                route_create: "finance.replenish.create"
            },
            columns: [
                {
                    title: "Procurement No",
                    field: "procurement_no",
                    filterable: true
                },
                {
                    title: "User Procurement",
                    field: "user_procurement",
                    filterable: false
                },
                {
                    title: "Vendor Name",
                    field: "vendor",
                    filterable: false
                },
                {
                    title: "Total Amount",
                    field: "total_amount",
                    type: "price",
                    filterable: true
                },
                {
                    title: "File",
                    field: "file_url",
                    type: "file",
                    filterable: true
                },
                {
                    title: "Status",
                    field: "status_html",
                    type: "html",
                    filterable: true
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
