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
                    title: "Upload Price Report",
                    action: false,
                    base_url: this.$parent.MakeUrl("api/v1/report/upload_price_report"),
                    noStartEnd: true
                },
                columns: [
                    {
                        title: "Name",
                        field: "name",
                        filterable: true
                    },
                    {
                        title: "Total Customer",
                        field: "TotCustomer",
                        filterable: true
                    },
                    {
                        title: "Total SKUID",
                        field: "TotSKU",
                        filterable: false
                    },

                    {
                        title: "Max End Periode",
                        field: "MaxEndPeriode",
                        filterable: true
                    },
                    {
                        title: "Type Price",
                        field: "TypePrice",
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
