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
        <div class="card card-body printableArea" id="printMe">
            <br>
            <br>
            <br>
            <br>
            <br>
            <h3>
        <span class="logo-text">
          <img
              v-bind:src="$parent.MakeUrl('assets/img/logo-frbox.png')"
              alt="homepage"
              class="light-logo"
          >
        </span>
            </h3>
            <hr>
            <div
                class="row"
                v-if="loading"
            >
                <div class="col-md-12">

                    <div class="text-center">
                        <table border="1" class="table-centered">
                            <tr style="text-align: center">
                                <td style="padding: 15px; text-align: center"><h4><b style="color: black">REKAPAN INVOICE</b></h4></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <div
                            class="table-responsive m-t-40"
                            style="clear: both;"
                        >
                            <table width="100%">
                                <tbody>

                                <tr>
                                    <td width="13%"><b>Kepada</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ invoice_order.customer_name }}</td>
                                    <td width="40%"></td>

                                </tr>

                                <tr>
                                    <td width="13%"><b>Tanggal</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ invoice_order.customer_address }}</td>
                                    <td width="40%"></td>

                                </tr>

                                <tr>
                                    <td width="13%"><b>Up</b></td>
                                    <td width="2%">:</td>
                                    <td width="40%">{{ invoice_order.sales_order_no }}</td>
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
                                <tr>
                                    <td>1</td>
                                    <td>111</td>
                                    <td>20-12-2019</td>
                                    <td>12121</td>
                                    <td>121212</td>
                                </tr>
                                <tr
                                    v-for="(item, index) in details"
                                    :key="index"
                                >
                                    <td>{{ item.skuid }}</td>
                                    <td>{{ item.item_name }}</td>
                                    <td>{{ item.uom_name }}</td>
                                    <td>{{ item.qty_confirm }}</td>
                                    <td>{{ item.amount_price }}</td>
                                    <td>{{ item.total_amount }}</td>
                                </tr>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>100000</td>
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
                                <div class="text-left">
                                    <h6>Diterima Oleh,</h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <h6>Jakarta, 20 Juni 2019</h6>
                                    <h6>Dibuat oleh,</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="text-left">
                                    <tr>
                                        <td>(</td>
                                        <td width="120px"></td>
                                        <td>)</td>
                                    </tr>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-right">
                                    <tr>
                                        <td>(</td>
                                        <td width="120px"></td>
                                        <td>)</td>
                                    </tr>
                                </div>
                            </div>
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


    </div>

</template>

<script>
    export default {
        props: ['id'],
        data() {
            return {
                invoice_order: {},
                details: [],
                errors:[],
                loading: false,
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                axios.all
                axios.get(this.$parent.MakeUrl('admin/finance/invoice_order/' + this.id + '/print'))
                    .then(res => {
                        this.invoice_order = res.data.data;
                        this.details = res.data.data.delivery_orders;
                        this.loading = true;
                    })
                    .catch(err => {
                        if (err.response.status == 500) {
                            this.loading = true;
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
        }
    }
</script>

<style>
    .table-centered {
        margin: 0 auto
    }
</style>
