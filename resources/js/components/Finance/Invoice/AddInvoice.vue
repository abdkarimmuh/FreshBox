<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12">
                <div class="card-header">
                    <h4 class="text-danger">Add Invoice Order</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <!-- Delivery Order No -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>Delivery Order No</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-bind:class="{'is-invalid': errors.do_id}"
                                        :list="list_delivery_order"
                                        v-model="do_id"
                                        v-on:input="getDataDO()"
                                        option-value="id"
                                        option-text="do_no_with_cust_name"
                                        placeholder="Select Delivery Order No"
                                    ></model-list-select>
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.do_id"
                                    >
                                        <p>{{ errors.do_id[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Sales Order No-->
                        <s-form-input
                            col="6"
                            title="Sales Order No"
                            :model="delivery_order.sales_order_no"
                            disabled="true"
                        ></s-form-input>
                        <!--Customer Name-->
                        <s-form-input
                            col="6"
                            title="Customer Name"
                            :model="delivery_order.customer_name"
                            disabled="true"
                        ></s-form-input>
                        <!-- DO Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>Invoice Date</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <date-picker
                                        v-model="invoice_date"
                                        lang="en"
                                        valueType="format"
                                        :not-before="new Date()"
                                    ></date-picker>
                                </div>
                                <div
                                    style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                    v-if="errors.invoice_date"
                                >
                                    <p>{{ errors.invoice_date[0] }}</p>
                                </div>
                            </div>
                        </div>

                        <div
                            v-if="do_id != ''"
                            class="col-12"
                        >
                            <div
                                class="table-responsive m-t-40"
                                style="clear: both;"
                            >
                                <table
                                    class="table table-hover"
                                    id="contentTable"
                                    style="font-size: 9pt;"
                                >
                                    <thead>
                                    <tr>
                                        <th class="text-center">SKUID</th>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center">UOM</th>
                                        <th class="text-center">Qty So</th>
                                        <th class="text-center">Qty Do</th>
                                        <th class="text-center">Qty Confirm</th>
                                        <th class="text-center">Amount Price</th>
                                        <th class="text-center">Total Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="(orders, index) in do_details"
                                        v-bind:key="index"
                                    >
                                        <td>{{ orders.skuid }}</td>
                                        <td>{{ orders.item_name }}</td>
                                        <td>{{ orders.uom_name }}</td>
                                        <td>{{ orders.qty_order }}</td>
                                        <td>{{ orders.qty_do }}</td>
                                        <td>{{ orders.qty_confirm }}</td>
                                        <td style="text-align: right;">{{ orders.amount_price }}</td>
                                        <td style="text-align: right;">{{ orders.total_amount }}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align: right;">Grand Total</td>
                                        <td style="text-align: right;">{{ delivery_order.total_price_not_returned }}
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card-body">
                                <button
                                    class="btn btn-danger"
                                    v-on:click="submitForm()"
                                >Submit
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    onclick="back()"
                                >Back
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {ModelListSelect} from "vue-search-select";

    export default {
        data() {
            return {
                do_id: "",
                invoice_date: "",
                user_id: UserID,
                delivery_order: {},
                list_delivery_order: [],
                do_details: [],
                errors: []
            };
        },
        mounted() {
            this.getData();
        },
        methods: {
            getDataDO() {
                axios.get(this.$parent.MakeUrl("admin/warehouse/delivery_order/" + this.do_id + "/show"))
                    .then(res => {
                        this.delivery_order = res.data.data;
                        this.do_details = res.data.data.do_details_not_returned;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            getData() {
                axios.get(this.$parent.MakeUrl("admin/finance/invoice_order/create")).then(res => {
                    this.list_delivery_order = res.data.data;
                }).catch(e => {
                    console.log(e);
                });
            },
            async submitForm() {
                const payload = {
                    so_id: this.delivery_order.sales_order_id,
                    customer_id: this.delivery_order.customer_id,
                    user_id: this.user_id,
                    do_id: this.do_id,
                    invoice_date: this.invoice_date
                };
                try {
                    const res = await axios.post(this.$parent.MakeUrl("admin/finance/invoice_order/store"), payload);
                    Vue.swal({
                        type: "success",
                        title: "Success!",
                        text: "Successfully Insert Data!"
                    });
                    console.log(res);
                    // setTimeout(function () {
                    //     window.location.href = "/admin/finance/invoice_order";
                    // }, 2500);
                } catch (e) {
                    this.errors = e.response.data.errors;
                    console.log(e);
                }
            },
        },
        components: {
            ModelListSelect
        }
    };
</script>

