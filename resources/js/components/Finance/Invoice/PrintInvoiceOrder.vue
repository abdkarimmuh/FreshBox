<template>
    <div>
        <div id="printMe">
            <print-header :logo="logo"></print-header>
            <div class="row" v-if="loading">
                <div class="col-md-12">
                    <div class="pull-right text-right">
                        <h4><b class="text-danger">Invoice<span
                            class="pull-right">#{{ invoice_order.invoice_no }}</span></b>
                        </h4>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive m-t-40">
                            <table width="100%">
                                <tbody>
                                <tr>
                                    <td width="13%"><b>Invoice Date</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ invoice_order.invoice_date }}</td>
                                    <td width="40%"></td>
                                </tr>
                                <tr>
                                    <td width="13%"><b>Delivery Order No</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ invoice_order.delivery_order_no }}</td>
                                    <td width="40%"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                       <div class="col-md-12">
                        <div class="table-responsive m-t-40">
                            <table width="100%">
                                <tbody>
                                <tr>
                                    <td width="13%"><b>Kepada Yth</b></td>
                                    <td width="2%">:</td>
                                </tr>

                                <tr>
                                    <td width="13%"><b>Customer</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ invoice_order.customer_name }}</td>
                                    <td width="40%"></td>
                                </tr>
                                <tr>
                                    <td width="13%"><b>PO No</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ invoice_order.no_po }}</td>
                                    <td width="40%"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <print-table :columns="columns" :data="details"></print-table>
                    <div class="col-md-12">
                        <table width="100%" style="border-top: 1px solid black">
                            <tbody>
                            <tr>
                                <td width="56%">Keterangan :</td>
                                <td style="border-bottom: 1px solid black;" class="text-right">Subtotal Rp</td>
                                <td style="border-bottom: 1px solid black;" class="text-right">{{
                                    invoice_order.total_price | toIDR }}
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
                                    invoice_order.total_price | toIDR }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <hr>
                    </div>
                    <div clas="col-md-12">
                        <div class="text-right mr-3">
                            <h6><b>{{ info.nama_pt }}</b></h6>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="mr-5">
                                <b>{{ info.nama_ttd }}</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive m-t-40" style="clear: both;">
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
                                                <td width="30%">{{ info.nama_pt }}</td>
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
                                                <td width="10%" colspan="5"><b>*) Pembayaran dianggap sah jika bukti

                                                    transfer sudah dikirimkan kepada kami</b></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <!--                                    <td width="10%">-->
                                    <!--                                        <table width="100%" border="1">-->
                                    <!--                                            <tbody>-->
                                    <!--                                            <tr>-->
                                    <!--                                                <td width="35%" class="text-center">Prepare by</td>-->
                                    <!--                                            </tr>-->
                                    <!--                                            <tr>-->
                                    <!--                                                <td height="78">&nbsp;</td>-->
                                    <!--                                            </tr>-->
                                    <!--                                            <tr>-->
                                    <!--                                                <td height="23" class="text-center"></td>-->
                                    <!--                                            </tr>-->
                                    <!--                                            </tbody>-->
                                    <!--                                        </table>-->
                                    <!--                                    </td>-->
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center p-4 text-muted" v-else>
                <h5>Loading</h5>
                <p>Please wait, data is being loaded...</p>
            </div>
        </div>
        <br>
        <div class="text-right">
            <button
                class="btn btn-secondary"
                type="button"
                @click="back()">Back
            </button>
            <button
                class="btn btn-success"
                @click="print">Print
            </button>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['id'],
        data() {
            return {
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
                        field: 'qty_confirm',
                        type: 'text',
                    },
                    {
                        title: 'Unit',
                        field: 'uom_name',
                        type: 'text',
                    },
                    {
                        title: 'Price',
                        field: 'amount_price',
                        type: 'currency',
                    },
                    {
                        title: 'Amount',
                        field: 'total_amount',
                        type: 'currency',
                    },
                ],
                logo: this.$parent.MakeUrl('assets/img/logo-frbox.png'),
                info: {
                    nama_pt: "PT BERKAH TANI SEJAHTERA",
                    nama_ttd: "Faizal Finanda",
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
                        if (err.response.status === 500) {
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

