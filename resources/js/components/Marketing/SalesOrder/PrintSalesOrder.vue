<template>
    <div>
        <div id="printMe">
            <div class="card card-body printableArea" style="page-break-after: always">
                <print-header :logo="logo"></print-header>
                <div class="row" v-if="loading">
                    <div class="col-md-12">
                        <div class="pull-right text-right">
                            <h4><b class="text-danger">Sales Order<span class="pull-right">#{{ sales_order.sales_order_no }}</span></b>
                            </h4>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table width="100%">
                                    <tbody>
                                    <tr>
                                        <td width="13%"><b>Supplier</b></td>
                                        <td width="2%">:</td>
                                        <td width="40%">{{ sales_order.customer_name }}</td>
                                        <td width="40%"></td>

                                    </tr>
                                    <tr>
                                        <td width="13%"><b>Address</b></td>
                                        <td width="2%">:</td>
                                        <td width="40%">{{ sales_order.customer_address}}</td>
                                        <td width="40%"></td>

                                    </tr>
                                    <tr>
                                        <td width="13%"><b>Sales Order Date</b></td>
                                        <td width="2%">:</td>
                                        <td width="40%">{{ sales_order.created_at }}</td>
                                        <td width="40%"></td>
                                    </tr>
                                    <tr>
                                        <td width="13%"><b>Fullfilment Date</b></td>
                                        <td width="2%">:</td>
                                        <td width="40%">{{ sales_order.fulfillment_date }}</td>
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
                                        v-for="(item, index) in details"
                                        :key="index"
                                    >
                                        <td>{{ item.skuid }}</td>
                                        <td>{{ item.item_name }}</td>
                                        <td>{{ item.uom_name }}</td>
                                        <td style="text-align: right;">{{ item.qty }}</td>
                                        <td style="text-align: right;">{{ item.amount_price_formated }}</td>
                                        <td style="text-align: right;">{{ item.total_amount_formated }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="pull-right m-t-30 text-right">
                                <p>Sub - Total : {{ sales_order.total_price }}</p>
                                <p>PPN : </p>
                                <p>PPh : - </p>
                                <hr>
                                <h3><b>Total :</b> {{ sales_order.total_price }}</h3>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table width="100%">
                                    <tbody>
                                    <tr>
                                        <td width="50%">
                                        <td width="10%">
                                            <table width="100%" border="1">
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
        </div>
        <div class="card card-body">
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
    </div>

</template>

<script>
    export default {
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
                sales_order: {},
                details: [],
                loading: false,
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                axios.get(this.$parent.MakeUrl('api/v1/marketing/sales_order/show?id=' + this.$route.params.id))
                    .then(res => {
                        this.sales_order = res.data;
                        this.details = res.data.sales_order_details;
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
                        axios.post(this.$parent.MakeUrl('admin/marketing/form_sales_order/print/' + this.$route.params.id))
                    }
                })
            },
            back() {
                this.$router.push({name: 'form_sales_order'});
            }
        }
    }
</script>

