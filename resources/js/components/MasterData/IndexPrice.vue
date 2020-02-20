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
                title: "Price",
                action: true,
                noStartEnd: true,
                customerGroup: true,
                base_url: this.$parent.MakeUrl(
                    "api/v1/master_data/price/getPrice"
                ),
                route_add: this.$parent.MakeUrl(
                    "admin/master_data/price/create"
                ),
                route_upload: this.$parent.MakeUrl("admin/import/price"),
                route_edit_price: true
            },
            columns: [
                {
                    title: "SKUID",
                    field: "skuid",
                    filterable: true
                },
                {
                    title: "Item Name",
                    field: "item_name",
                    filterable: false
                },
                {
                    title: "UOM",
                    field: "uom_name",
                    filterable: false
                },
                {
                    title: "Customer Group Name",
                    field: "customer_group_name",
                    filterable: true
                },
                {
                    title: "Amount",
                    field: "amount",
                    type: "price",
                    filterable: true
                },
                {
                    title: "Tax",
                    field: "tax_value",
                    type: "price",
                    filterable: true
                },
                {
                    title: "Start Periode",
                    field: "start_periode",
                    filterable: true
                },
                {
                    title: "End Periode",
                    field: "end_periode",
                    filterable: true
                },
                {
                    title: "Remarks",
                    field: "remarks",
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
