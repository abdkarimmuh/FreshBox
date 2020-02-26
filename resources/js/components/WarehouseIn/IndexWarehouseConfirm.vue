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
                title: "Confirm Incoming Items",
                action: true,
                base_url: this.$parent.MakeUrl("api/v1/warehouseIn/confirm"),
                route_create: "warehouseIn.confirm.create"
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
