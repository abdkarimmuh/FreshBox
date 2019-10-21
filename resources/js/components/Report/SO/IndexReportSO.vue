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
                    title: 'Report SO',
                    base_url: '',
                    daterange: true,
                    export_excel: true,
                    action: false,

                },
                columns: [
                    {
                        title: 'Tanggal',
                        field: 'so_date',
                        filterable: true,
                    },
                    {
                        title: 'Customer',
                        field: 'customer_name',
                        filterable: true,
                    },
                    {
                        title: 'PO Customer No',
                        field: 'po_no',
                        filterable: false,
                    },
                    {
                        title: 'SO No.',
                        field: 'sales_order_no',
                        filterable: true,
                    },
                    {
                        title: 'Category',
                        field: 'category_name',
                        filterable: true,
                    },
                    {
                        title: 'Item Code',
                        field: 'skuid',
                        filterable: true,
                    },
                    {
                        title: 'Item Name',
                        field: 'item_name',
                        filterable: true,
                    },
                    {
                        title: 'Kg',
                        field: 'uom_name',
                        filterable: true,
                    },
                    {
                        title: 'Price / each',
                        field: 'item_price',
                        filterable: true,
                    },
                    {
                        title: 'Type Price',
                        field: 'customer_group_name',
                        filterable: true,
                    },
                    {
                        title: 'Quantity',
                        field: 'qty',
                        filterable: true,
                    },
                    {
                        title: 'DO No.',
                        field: 'delivery_order_no',
                        filterable: true,
                    },
                    {
                        title: 'Quantity',
                        field: 'qty_do',
                        filterable: true,
                    },
                    {
                        title: 'Total Amount',
                        field: 'total_amount',
                        filterable: true,
                    },
                    {
                        title: 'Disc',
                        field: 'amount_disc',
                        filterable: true,
                    },
                    {
                        title: 'Total Amount (After Disc)',
                        field: 'total_amount',
                        filterable: true,
                    }

                ],
                error:
                    {
                        code: 403,
                        description:
                            'You do not have access to this page'
                    }
            }
        },
    }
</script>
