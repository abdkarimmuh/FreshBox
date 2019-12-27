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
                action: true,
                base_url: this.$parent.MakeUrl(
                    "api/v1/warehouseIn/packageItem"
                ),
                route_multiple_print: "form_sales_order.multiplePrint"
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
