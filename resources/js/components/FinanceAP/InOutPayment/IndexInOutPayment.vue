<template>
    <div v-if="$parent.userRole('Admin')">
        <s-table :config="config" :columns="columns"/>
    </div>
    <div v-else>
        <s-error-page :error="error"/>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                config: {
                    title: "In/Out Payment",
                    action: true,
                    base_url: this.$parent.MakeUrl("api/v1/finance-ap/in-out-payment"),
                    route_view: "finance.inOutPayment.show",
                    // route_multiple_print: 'invoice_order.multiplePrint',
                },
                columns: [
                    {
                        title: "Status",
                        field: "status_name",
                        filterable: true,
                        type: 'html'
                    },
                    {
                        title: "Nama Vendor",
                        field: "vendor_name",
                        filterable: true
                    },
                    {
                        title: "Jumlah",
                        field: "amount",
                        filterable: false
                    },
                    {
                        title: "Created At",
                        field: "created_at",
                        filterable: true
                    },

                ],
                error: {
                    code: 403,
                    description: "You do not have access to this page"
                }
            };
        }
    };
</script>
