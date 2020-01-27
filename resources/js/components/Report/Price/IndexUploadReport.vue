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
                title: "Report Price Upload",
                base_url: "",
                daterange: true,
                export_excel: true,
                url_export: "report-price-upload/export",
                action: false
            },
            columns: [
                {
                    title: "Nama",
                    field: "name",
                    filterable: true
                },
                {
                    title: "Total Customer",
                    field: "total_cust",
                    filterable: false
                },
                {
                    title: "Total SKUID",
                    field: "tot_skuid",
                    filterable: false
                },
                {
                    title: "Max End Periode",
                    field: "end_periode",
                    filterable: false
                },
                {
                    title: "Type Price",
                    field: "type_price",
                    filterable: false
                },
                {
                    title: "Remarks",
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
