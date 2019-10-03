<template>
    <div>
        <div id="printMe">
            <br>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="text-left">
                        <table>
                            <tbody>
                            <tr>
                                <td><b>PT BERKAH TANI SEJAHTERA</b></td>
                            </tr>
                            <tr>
                                <td><b>Rukan Greenlake Ruko Greatwall B60 - B61</b></td>
                            </tr>
                            <tr>
                                <td><b>Cipondoh - Tangerang 15147</b></td>
                            </tr>
                            <tr>
                                <td><b>Telp : 012-54315198</b></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-right">
                        <img v-bind:src="$parent.MakeUrl('assets/img/logo-frbox.png')">
                    </div>
                </div>
            </div>
            <hr>
            <div class="row" v-if="loading">

                <div class="col-md-12">
                    <div class="pull-right text-right">
                        <address>
                            <h4><b class="text-danger">Invoice<span
                                class="pull-right">#{{ invoice_order.invoice_no }}</span></b>
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
                                    <td width="40%">{{ invoice_order.customer_name }}</td>
                                    <td width="40%"></td>

                                </tr>

                                <tr>
                                    <td width="13%"><b>Address</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ invoice_order.customer_address }}</td>
                                    <td width="40%"></td>

                                </tr>

                                <!--                                <tr>-->
                                <!--                                    <td width="13%"><b>Sales Order No</b></td>-->
                                <!--                                    <td width="2%">:</td>-->
                                <!--                                    <td width="40%">{{ invoice_order.sales_order_no }}</td>-->
                                <!--                                    <td width="40%"></td>-->

                                <!--                                </tr>-->

                                <tr>
                                    <td width="13%"><b>Delivery Order No</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ invoice_order.delivery_order_no }}</td>
                                    <td width="40%"></td>

                                </tr>

                                <tr>
                                    <td width="13%"><b>Invoice Date</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ invoice_order.invoice_date }}</td>
                                    <td width="40%"></td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <table width="100%">
                            <thead>
                            <tr style="border-bottom: 1px solid black; border-top: 1px solid black">
                                <th>No</th>
                                <th>Item No</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>UOM</th>
                                <th>Price</th>
                                <th>Total Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr style="border-bottom: 0px" v-for="(item, index) in details" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.skuid }}</td>
                                <td>{{ item.item_name }}</td>
                                <td>{{ item.qty_confirm }}</td>
                                <td>{{ item.uom_name }}</td>
                                <td>{{ item.amount_price }}</td>
                                <td>{{ item.total_amount }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <table width="100%" style="border-top: 1px solid black">
                            <tbody>
                            <tr>
                                <td width="70%">Keterangan :</td>
                                <td style="border-bottom: 1px solid black;">Subtotal</td>
                                <td style="border-bottom: 1px solid black;">{{ invoice_order.total_price | toIDR }}</td>
                            </tr>
                            <tr>
                                <td width="70%"></td>
                                <td style="border-bottom: 1px solid black;">Discount</td>
                                <td style="border-bottom: 1px solid black;"></td>
                            </tr>
                            <tr>
                                <td width="70%"></td>
                                <td style="border-bottom: 1px solid black;">Pajak</td>
                                <td style="border-bottom: 1px solid black;"></td>
                            </tr>
                            <tr>
                                <td width="70%"></td>
                                <td style="border-bottom: 1px solid black;">Total</td>
                                <td style="border-bottom: 1px solid black;">{{ invoice_order.total_price | toIDR }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <!--                        <div class  ="pull-right m-t-30 text-right">-->
                        <!--                            <p>Sub - Total : {{ invoice_order.total_price | toIDR }}</p>-->
                        <!--                            <p>PPN : </p>-->
                        <!--                            <p>PPh : - </p>-->
                        <!--                            <hr>-->
                        <!--                            <h3><b>Total :</b> {{ invoice_order.total_price | toIDR }}</h3>-->
                        <!--                        </div>-->
                        <!--                        <div class="clearfix"></div>-->
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div
                            class="table-responsive m-t-40"
                            style="clear: both;"
                        >
                            <table width="100%">
                                <tbody>
                                <tr>
                                    <td width="60%">
                                        <table width="100%">
                                            <tbody>
                                            <tr>
                                                <td width="10%"><b><h6>Harap Transfer Ke</h6></b></td>
                                                <td width="2%">:</td>
                                                <td width="30%"></td>
                                                <td width="8%"></td>
                                            </tr>
                                            <tr>
                                                <td width="2%"><b>Penerima</b></td>
                                                <td width="2%">:</td>
                                                <td width="30%">{{ info.penerima }}</td>
                                                <td width="8%"></td>
                                            </tr>
                                            <tr>
                                                <td width="2%"><b>No Rekening</b></td>
                                                <td width="2%">:</td>
                                                <td width="30%">{{ info.no_rek }}</td>
                                                <td width="8%"></td>
                                            </tr>
                                            <tr>
                                                <td width="2%"><b>Bank</b></td>
                                                <td width="2%">:</td>
                                                <td width="30%">{{ info.bank }}</td>
                                                <td width="8%"></td>
                                            </tr>
                                            <tr>
                                                <td><br></td>
                                            </tr>
                                            <tr>
                                                <td width="10%" colspan="5"><b>*) Pembayarang dianggap sah jika bukti
                                                    transfer sudah dikirimkan kepada kami</b></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td width="10%">
                                        <table
                                            width="100%"
                                            border="1"
                                        >
                                            <tbody>
                                            <tr>
                                                <td
                                                    width="35%"
                                                    class="text-center"
                                                >Prepare by
                                                </td>

                                            </tr>
                                            <tr>
                                                <td height="78">&nbsp;</td>

                                            </tr>

                                            <tr>
                                                <td
                                                    height="23"
                                                    class="text-center"
                                                ></td>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="text-center p-4 text-muted"
                v-else
            >
                <h5>Loading</h5>
                <p>Please wait, data is being loaded...</p>
            </div>

        </div>
        <br>
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
    import Table from "../../DataTable/partials/Table";

    export default {
        components: {Table},
        props: ['id'],
        data() {
            return {
                info: {
                    penerima: "PT BERKAH TANI SEJAHTERA",
                    no_rek: "008 500 9779",
                    bank: "BCA Cabang BCBD"
                },
                invoice_order: {},
                details: [],
                loading: false,
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                axios.get(this.$parent.MakeUrl('admin/finance/invoice_order/' + this.id + '/print'))
                    .then(res => {
                        this.invoice_order = res.data.data;
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
                Vue.swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Print it!'
                }).then((result) => {
                    if (result.value) {
                        this.$htmlToPaper('printMe');
                        axios.post(this.$parent.MakeUrl('admin/finance/invoice_order/' + this.id + '/print'))
                        // Swal.fire(
                        //     'Printed!',
                        //     'This Sales Order has been Printed.',
                        //     'success'
                        // )
                    }
                })
            },
            back() {
                return window.location.href = this.$parent.MakeUrl('admin/finance/invoice_order');
            }
        },
        computed: {
            total_price: function () {
                let total = 0;
                this.details.forEach(function (item) {
                    total += (item.total_amount)
                });
                return total.toLocaleString("id-ID", {
                    minimumFractionDigits: 2
                });
            }
        }
    }
</script>

