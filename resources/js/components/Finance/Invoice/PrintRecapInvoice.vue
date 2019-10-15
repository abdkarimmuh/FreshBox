<template>
    <div>
        <div class="text-left">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <b>Customer</b>
                        <span style="color: red;">*</span>
                    </label>
                    <div>
                        <model-list-select :list="customers" v-model="customer_id" v-on:input="getInvoiceList()"
                                           option-value="id"
                                           option-text="name"
                                           placeholder="Select Customer">
                        </model-list-select>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right">
            <button class="btn btn-secondary" type="button" @click="back()">
                Back
            </button>
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
                                    <td width="40%">{{ customer.tanggal | toDate }}</td>
                                    <td width="40%"></td>

                                </tr>

                                <tr>
                                    <td width="13%"><b>Up</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%"></td>
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" border="1">
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
                                    <td>{{ index + 1}}</td>
                                    <td>{{ item.invoice_no }}</td>
                                    <td>{{ item.invoice_date}}</td>
                                    <td>{{ item.total_price | toIDR }}</td>
                                    <td></td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ customer.subtotal | toIDR}}</td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="clearfix"></div>
                        <hr>
                    </div>
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
                                    <h6>Jakarta, {{ customer.tanggal | toDate }}</h6>
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
                customers: [],
                invoices: [],
                loading: false,
            }
        },
        mounted() {
            this.getInvoiceList();
        },
        methods: {
            getInvoiceList() {
                const payload = {
                    id: this.$route.query.id,
                };
                axios.get(this.$parent.MakeUrl('api/v1/finance/invoice/printRecap/' + this.customer_id))
                    .then(res => {
                        this.customer = res.data.data;
                        this.invoices = res.data.data.invoices;
                        this.customer.tanggal = new Date();
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
        }
    }
</script>

<style>
    .table-centered {
        margin: 0 auto
    }
</style>
