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
                    title: "Barcode",
                    field: "no_do",
                    filterable: true,
                    type: "barcode"
                },
                {
                    title: "Fullfilment Date",
                    field: "fullfilment_date",
                    filterable: true
                },
                {
                    title: "Customer Name",
                    field: "customer_name",
                    filterable: true
                },
                {
                    title: "SKU ID",
                    field: "skuid",
                    filterable: true
                },
                {
                    title: "Item Name",
                    field: "item_name",
                    filterable: true
                },

                {
                    title: "Qty DO",
                    field: "qty_do",
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
