<template>
    <div>
        <div class="text-right">
            <button
                class="btn btn-secondary"
                type="button"
                @click="back()"
            > Back
            </button>
            <button
                class="btn btn-success"
                @click="print"
            > Print
            </button>
        </div>
        <div id="printMe" v-if="loading">
            <div style="page-break-after: always" v-for="(item, index) in delivery_order">
                <print-header></print-header>
                <div class="row" v-if="loading">
                    <div class="col-md-12">
                        <print-header-info :header_info="header_info" :data="item"
                                           :info="info"></print-header-info>
                        <br>
                        <print-table :columns="columns" :data="item.do_details"></print-table>
                        <br>
                        <div class="col-md-12">
                            <table width="100%" style="border-top: 1px solid black">
                                <tbody>
                                <tr>
                                    <td height="70px" width="56%">Keterangan :</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="border-bottom: 1px solid black"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <h6>Disiapkan oleh,</h6>
                                </div>
                                <div class="col-md-3">
                                    <h6>Driver,</h6>
                                </div>
                                <div class="col-md-3">
                                    <h6>Diterima oleh,</h6>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center p-4 text-muted" v-else>
            <h5>Loading</h5>
            <p>Please wait, data is being loaded...</p>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['id'],
        data() {
            return {
                info: {
                    title: "Delivery Order",
                    no: "delivery_order_no",
                },
                columns: [
                    {
                        title: 'Item No',
                        field: 'skuid',
                        type: 'text',
                    },
                    {
                        title: 'Item Name',
                        field: 'item_name',
                        type: 'text',
                        alignmentLeft: true,
                    },
                    {
                        title: 'Qty',
                        field: 'qty_do',
                        type: 'text',
                    },
                    {
                        title: 'Unit',
                        field: 'uom_name',
                        type: 'text',
                    },
                    {
                        title: 'Remarks',
                        field: 'remark',
                        type: 'text',
                    }
                ],
                header_info: [
                    {
                        title: "Delivery Order Date",
                        field: "do_date",
                    },
                    // {
                    //     title: "Delivery Order No",
                    //     field: "delivery_order_no",
                    // },
                    {
                        page_break: true,
                    },
                    {
                        title: "Kepada Yth",
                        field: "",
                    },
                    {
                        title: "PO No.",
                        field: "no_po",
                    },
                    {
                        title: "Customer",
                        field: "customer_name",
                    },

                ],
                delivery_order: [],
                loading: false,
            }
        },
        mounted() {
            this.getData();

        },
        methods: {
            getData() {
                const payload = {
                    id: this.$route.query.id,
                };
                axios.get(this.$parent.MakeUrl('api/v1/warehouse/delivery_order/show'), {params: payload})
                    .then(res => {
                        this.delivery_order = res.data.data;
                        this.loading = true;
                        console.log(res);
                    }).catch(e => {
                    if (e.response.status === 500) {
                        this.getData()
                    }
                });
                this.sales_order = this.data;
            },
            print() {
                this.$htmlToPaper('printMe');
            },
            back() {
                return window.location.href = this.$parent.MakeUrl('admin/warehouse/delivery_order');
            }
        }
    }
</script>

