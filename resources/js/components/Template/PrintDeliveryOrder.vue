<template>
    <div>
        <div
            class="card card-body printableArea"
            id="printMe"
        >
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
                        <div
                            class="table-responsive m-t-40"
                            style="clear: both;"
                        >
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">SKUID</th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">UOM</th>
                                    <th class="text-center">Qty SO</th>
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
                                    <td>{{ item.qty_order }}</td>
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
            <div
                class="text-center p-4 text-muted"
                v-else
            >
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
            <!--            <button-->
            <!--                class="btn btn-warning"-->
            <!--                id="returnSalesOrder"-->
            <!--            > Return-->
            <!--            </button>-->
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

