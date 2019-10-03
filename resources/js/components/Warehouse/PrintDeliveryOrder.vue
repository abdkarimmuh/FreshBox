<template>
    <div>
        <div id="printMe">
            <print-header :logo="logo"></print-header>
            <div class="row" v-if="loading">
                <div class="col-md-12">
                    <print-header-info :header_info="header_info" :data="sales_order"
                                       :info="info"></print-header-info>
                    <div class="pull-right text-right">
                        <address>
                            <h4><b class="text-danger">Delivery Order<span class="pull-right">#{{ delivery_order.delivery_order_no }}</span></b>
                            </h4>

                        </address>
                    </div>

                    <div class="col-md-12">
                        <div
                            class="table-responsive m-t-40"
                            style="clear: both;"
                        >
                            <table width="100%">
                                <tbody>

                                <tr>
                                    <td width="13%"><b>Supplier</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ delivery_order.customer_name }}</td>
                                    <td width="40%"></td>

                                </tr>

                                <tr>
                                    <td width="13%"><b>Address</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%"></td>
                                    <td width="40%"></td>

                                </tr>

                                <tr>
                                    <td width="13%"><b>Sales Order No</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ delivery_order.sales_order_no }}</td>
                                    <td width="40%"></td>

                                </tr>

                                <tr>
                                    <td width="13%"><b>Delivery Order No</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ delivery_order.delivery_order_no }}</td>
                                    <td width="40%"></td>

                                </tr>

                                <tr>
                                    <td width="13%"><b>Delivery Order Date</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ delivery_order.do_date }}</td>
                                    <td width="40%"></td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                <tr>
                                    <th class="text-center">SKUID</th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">UOM</th>
                                    <th class="text-center">Qty DO</th>
                                    <th class="text-center">Remark</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="(item, index) in details"
                                    :key="index"
                                >
                                    <td>{{ item.skuid }}</td>
                                    <td>{{ item.item_name }}</td>
                                    <td>{{ item.uom_name }}</td>
                                    <td>{{ item.qty_do }}</td>
                                    <td>{{ item.remark }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table width="100%" style="border-top: 1px solid black">
                            <tbody>
                            <tr>
                                <td width="56%">Keterangan :</td>
                                <td style="border-bottom: 1px solid black;" class="text-right">Subtotal Rp</td>
                                <td style="border-bottom: 1px solid black;" class="text-right">{{
                                    sales_order.total_price | toIDR }}
                                </td>
                            </tr>
                            <tr>
                                <td width="56%"></td>
                                <td style="border-bottom: 1px solid black;" class="text-right">Discount Rp</td>
                                <td style="border-bottom: 1px solid black;" class="text-right"></td>
                            </tr>
                            <tr>
                                <td width="56%"></td>
                                <td style="border-bottom: 1px solid black;" class="text-right">Pajak Rp</td>
                                <td style="border-bottom: 1px solid black;" class="text-right"></td>
                            </tr>
                            <tr>
                                <td width="56%"></td>
                                <td style="border-bottom: 1px solid black;" class="text-right">Total Rp</td>
                                <td style="border-bottom: 1px solid black;" class="text-right">{{
                                    sales_order.total_price | toIDR }}
                                </td>
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
                        field: 'qty',
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

