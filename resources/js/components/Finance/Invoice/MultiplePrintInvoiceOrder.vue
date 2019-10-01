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
            <div class="card card-body" style="page-break-after: always" v-for="(item, index) in invoice_order">
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
                        <div class="pull-right text-right">
                            <address>
                                <h4><b class="text-danger">Invoice<span
                                    class="pull-right">#{{ item.invoice_no }}</span></b>
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
                                        <td width="40%">{{ item.customer_name }}</td>
                                        <td width="40%"></td>

                                    </tr>

                                    <tr>
                                        <td width="13%"><b>Address</b></td>
                                        <td width="2%">:</td>
                                        <td width="40%">{{ item.customer_address }}</td>
                                        <td width="40%"></td>

                                    </tr>

                                    <tr>
                                        <td width="13%"><b>Sales Order No</b></td>
                                        <td width="2%">:</td>
                                        <td width="40%">{{ item.sales_order_no }}</td>
                                        <td width="40%"></td>

                                    </tr>

                                    <tr>
                                        <td width="13%"><b>Delivery Order No</b></td>
                                        <td width="2%">:</td>
                                        <td width="40%">{{ item.delivery_order_no }}</td>
                                        <td width="40%"></td>

                                    </tr>

                                    <tr>
                                        <td width="13%"><b>Invoice Date</b></td>
                                        <td width="2%">:</td>
                                        <td width="40%">{{ item.invoice_date }}</td>
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
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Amount Price</th>
                                        <th class="text-center">Total Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="(row, index) in item.do_details"
                                        :key="index"
                                    >
                                        <td>{{ row.skuid }}</td>
                                        <td>{{ row.item_name }}</td>
                                        <td>{{ row.uom_name }}</td>
                                        <td>{{ row.qty_confirm }}</td>
                                        <td>{{ row.amount_price }}</td>
                                        <td>{{ row.total_amount }}</td>
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
                            <div class="pull-right m-t-30 text-right">
                                <p>Sub - Total : {{ item.total_price | toIDR }}</p>
                                <p>PPN : </p>
                                <p>PPh : - </p>
                                <hr>
                                <h3><b>Total :</b> {{ item.total_price | toIDR }}</h3>
                            </div>
                            <div class="clearfix"></div>
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
                                        <td width="50%">
                                            <table width="100%">
                                                <tbody>
                                                <tr>
                                                    <td width="2%"><b>Bank</b></td>
                                                    <td width="2%">:</td>
                                                    <td width="30%"></td>
                                                    <td width="8%"></td>
                                                </tr>
                                                <tr>
                                                    <td width="2%"><b>Account No</b></td>
                                                    <td width="2%">:</td>
                                                    <td width="30%"></td>
                                                    <td width="8%"></td>
                                                </tr>
                                                <tr>
                                                    <td width="2%"><b>Beneficiary</b></td>
                                                    <td width="2%">:</td>
                                                    <td width="30%"></td>
                                                    <td width="8%"></td>
                                                </tr>
                                                <tr>
                                                    <td width="2%"><b>Branch</b></td>
                                                    <td width="2%">:</td>
                                                    <td width="30%"></td>
                                                    <td width="8%"></td>
                                                </tr>
                                                <tr>
                                                    <td width="2%"><b>Swift Code</b></td>
                                                    <td width="2%">:</td>
                                                    <td width="30%"></td>
                                                    <td width="8%"></td>
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
            </div>
        </div>
        <div class="text-center p-4 text-muted" v-else>
            <h1>Loading</h1>
            <p>Please wait, data is being loaded...</p>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['id'],
        data() {
            return {
                invoice_order: [],
                loading: false,
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                const id = JSON.parse(this.id).map(Number);
                const payload = {
                    id: id,
                };

                axios.get(this.$parent.MakeUrl('admin/finance/invoice_order/multiplePrint'), {params: payload})
                    .then(res => {
                        this.invoice_order = res.data;
                        this.loading = true;
                    })
                    .catch(e => {
                        if (e.response.status == 500) {
                            this.getData();
                        }
                    })
            },
            async print() {
                const payload = {
                    id: this.invoice_order.map(item => item.sales_order_id),
                };
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
                        axios.post(this.$parent.MakeUrl('admin/finance/invoice_order/multiplePrint'), payload);
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

