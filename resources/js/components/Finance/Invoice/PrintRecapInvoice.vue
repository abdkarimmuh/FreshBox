<template>
    <div>
        <div class="text-right">
            <back-button/>
            <button
                class="btn btn-success"
                @click="print">
                Print
            </button>
        </div>
        <div class="card card-body printableArea" id="printMe">
            <br>
            <br>
            <br>
            <br>
            <br>
            <h3>
        <span class="logo-text">
          <img v-bind:src="$parent.MakeUrl('assets/img/logo-frbox.png')"
               alt="homepage"
               class="light-logo">
        </span>
                <div class="col-md-6">
                    <div class="text-left">
                        <table>
                            <tbody>
                            <tr>
                                <td><b>PT Berkah Tani Sejahtera</b></td>
                            </tr>
                            <tr>
                                <td><b>{{ customer.recap_invoice_no }}</b></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </h3>
            <hr>
            <div class="row" v-if="loading">
                <div class="col-md-12">
                    <div class="text-center">
                        <table border="1" style="margin: 0 auto">
                            <tr style="text-align: center">
                                <td style="padding: 15px; text-align: center">
                                    <h4>
                                        <b style="color: black">REKAPAN INVOICE</b>
                                    </h4>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive m-t-40"
                             style="clear: both;">
                            <table width="100%">
                                <tbody>
                                <tr>
                                    <td width="13%"><b>Kepada</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ customer.customer_name }}</td>
                                    <td width="40%"></td>

                                </tr>
                                <tr>
                                    <td width="13%"><b>Tanggal</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ customer.recap_date }}</td>
                                    <td width="40%"></td>

                                </tr>

                                <tr>
                                    <td width="13%"><b>Up</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ customer.up }}</td>
                                    <td width="40%"></td>

                                </tr>
                                <br>

                                <tr>
                                    <td><b style="text-decoration: underline">Mohon diterima</b></td>
                                    <td>:</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <table border="1" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">Nomor Invoice</th>
                                <th class="text-center">Tanggal Kirim</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in invoices">
                                <td class="text-center">{{ index + 1}}</td>
                                <td class="text-center">{{ item.invoice_no }}</td>
                                <td class="text-center">{{ item.send_date }}</td>
                                <td class="text-center">{{ item.price | toIDR }}</td>
                                <td></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">{{ subTotal | toIDR}}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-left ml-4">
                                    <h6>Diterima Oleh,</h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right mr-4">
                                    <h6>Jakarta, {{ customer.recap_date }}</h6>
                                    <h6>Dibuat oleh,</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                (........................................)
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    (........................................)
                                </div>
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


    </div>

</template>

<script>
    export default {
        props: ['id'],
        data() {
            return {
                customer_id: "",
                customer: {},
                invoices: [],
                loading: false,
            }
        },
        mounted() {
            this.getInvoice();
        },
        methods: {
            getInvoice() {
                axios.get(this.$parent.MakeUrl('api/v1/finance/invoice_recap/show/' + this.$route.params.id))
                    .then(res => {
                        this.customer = res.data.data;
                        this.invoices = res.data.data.invoice_recap_detail;
                        this.loading = true;
                        console.log(this.customer);
                    }).catch(e => {

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
                        // axios.post(this.$parent.MakeUrl('admin/finance/invoice_order/' + this.id + '/print'))
                    }
                })
            },
        },
        computed: {
            subTotal: function () {
                let sum = 0;
                this.invoices.forEach(function (item) {
                    sum += item.price
                });
                return sum
            }
        }
    }
</script>

<style>
    .table-centered {
        margin: 0 auto
    }
</style>
