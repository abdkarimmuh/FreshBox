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
                title: "In/Out Payment",
                action: true,
                actionPrint: false,
                base_url: this.$parent.MakeUrl(
                    "api/v1/finance-ap/in-out-payment"
                ),
                noStartEnd: true,
                route_create: "finance.inOutPayment.create",
                route_view: "finance.inOutPayment.show",
                route_receive_inout: true,
                route_confirm_inout: "finance.inOutPayment.confirm"
            },
            columns: [
                {
                    title: "Source Data",
                    field: "source_data",
                    filterable: true
                },
                {
                    title: "File",
                    field: "file_url",
                    type: "file",
                    filterable: false
                },
                {
                    title: "Tipe Transaksi",
                    field: "type_transaction",
                    type: "html"
                },
                {
                    title: "Opsi Transaksi",
                    field: "option_transaction",
                    type: "html"
                },
                {
                    title: "Bank",
                    field: "bank_name",
                    filterable: true
                },
                {
                    title: "Jumlah",
                    field: "amount",
                    filterable: false,
                    type: "price"
                },
                {
                    title: "Status",
                    field: "status_html",
                    filterable: true,
                    type: "html"
                },

                {
                    title: "Remark",
                    field: "remarks",
                    filterable: false
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
