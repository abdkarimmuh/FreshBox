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
                title: "Package Item",
                actionPrint: true,
                noStartEnd: true,
                base_url: this.$parent.MakeUrl(
                    "api/v1/warehouseIn/packageItem"
                ),
                route_multiple_print: "warehouseIn.packageItem.printLabel"
            },
            columns: [
                {
                    title: "Item Name",
                    field: "item_name",
                    filterable: true
                },
                {
                    title: "Sales Order NO",
                    field: "sales_order_no",
                    filterable: true
                },
                {
                    title: "Qty",
                    field: "qty",
                    filterable: true
                },
                {
                    title: "UOM",
                    field: "uom_name",
                    filterable: true
                },
                {
                    title: "Status",
                    field: "status_name",
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
