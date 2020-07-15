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
                title: "Form Sales Order",
                action: true,
                base_url: this.$parent.MakeUrl("api/v1/marketing/sales_order"),
                // route_search: 'admin.marketing.sales_order.index',
                route_create: "form_sales_order.create",
                route_view: "form_sales_order.print",
                route_edit: "form_sales_order.edit",
                route_multiple_print: "form_sales_order.multiplePrint"
            },
            columns: [
                {
                    title: "Sales Order NO",
                    field: "sales_order_no",
                    filterable: true
                },
                {
                    title: "Customer",
                    field: "customer_name",
                    filterable: true
                },
                {
                    title: "Source Order",
                    field: "source_order_name",
                    filterable: false
                },
                {
                    title: "Fulfillment Date",
                    field: "fulfillment_date",
                    filterable: true
                },
                {
                    title: "PO No.",
                    field: "no_po",
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
