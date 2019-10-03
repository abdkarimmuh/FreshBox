<template>
    <div>
        <div id="printMe">
            <print-header :logo="logo"></print-header>
            <div class="row" v-if="loading">
                <div class="col-md-12">
                    <print-header-info :header_info="header_info" :data="delivery_order"
                                       :info="info"></print-header-info>
                    <br>
                    <print-table :columns="columns" :data="details"></print-table>
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
                            <tr>
                                <td height="22px" width="100%" style="border-bottom: 1px solid black"></td>
                            </tr>
                            </tbody>
                        </table>
                        <hr style="height: 2px; background-color: black">
                    </div>
                    <div class="col-md-12">
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
            <div class="text-center p-4 text-muted" v-else>
                <h5>Loading</h5>
                <p>Please wait, data is being loaded...</p>
            </div>
        </div>

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
                    },
                    {
                        title: 'Qty',
                        field: 'qty_order',
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
                logo: this.$parent.MakeUrl('assets/img/logo-frbox.png'),
                delivery_order: {},
                details: [],
                loading: false,
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                axios.get(this.$parent.MakeUrl('admin/warehouse/delivery_order/' + this.id + '/show'))
                    .then(res => {
                        this.delivery_order = res.data.data;
                        this.details = res.data.data.do_details;
                        this.loading = true;
                    })
                    .catch(err => {
                        if (err.response.status == 500) {
                            this.getData();
                        }
                    })
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

