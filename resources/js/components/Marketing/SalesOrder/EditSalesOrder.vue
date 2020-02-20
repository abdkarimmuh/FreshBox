<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12">
                <div class="card-header">
                    <h4 class="text-danger">Sales Order Details</h4>
                </div>

                <div class="col-12">
                    <div class="row" v-if="loading">
                        <s-form-input
                            :model="sales_order.source_order_name"
                            col="6"
                            title="Source Order"
                            type="text"
                            :disabled="true"
                        ></s-form-input>

                        <div class="col-md-3">
                            <div
                                class="form-group"
                                v-if="sales_order.source_order_id"
                            >
                                <label><b>File</b></label>
                                <div>
                                    <a v-bind:href="sales_order.file_url">{{
                                        sales_order.file
                                    }}</a>
                                </div>
                            </div>
                        </div>

                        <s-form-input
                            v-if="sales_order.source_order_id == 1"
                            :model="sales_order.no_po"
                            col="3"
                            title="No PO"
                            type="text"
                            :disabled="true"
                        ></s-form-input>

                        <s-form-input
                            :model="sales_order.customer_name"
                            col="6"
                            title="Customer"
                            type="text"
                            :disabled="true"
                        ></s-form-input>

                        <s-form-input
                            :model="sales_order.fulfillment_date"
                            col="3"
                            title="Fulfillment Date"
                            type="text"
                            :disabled="true"
                        ></s-form-input>

                        <s-form-input
                            :model="sales_order.driver_name"
                            col="3"
                            title="Fulfillment Date"
                            type="text"
                            :disabled="true"
                        ></s-form-input>

                        <div
                            class="col-md-6"
                            v-if="sales_order.customer_id != 0"
                        >
                            <div class="form-group">
                                <label
                                    ><b>Items</b
                                    ><span style="color: red;">*</span></label
                                >
                                <model-list-select
                                    :list="items"
                                    v-model="skuid"
                                    v-on:input="getItem()"
                                    option-value="skuid"
                                    option-text="item_name"
                                    placeholder="Select Item"
                                >
                                </model-list-select>
                            </div>
                        </div>

                        <div
                            class="col-md-6 mt-4"
                            v-if="sales_order.skuid != ''"
                        >
                            <div class="form-group">
                                <label></label>
                                <button
                                    class="btn btn-sm btn-primary"
                                    @click="pushOrderDetails(skuid)"
                                >
                                    Add Items
                                </button>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div
                                style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                v-if="errors.items"
                            >
                                <p>{{ errors.items[0] }}</p>
                            </div>
                        </div>

                        <div v-if="sales_order.customer_id != 0" class="col-12">
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
                                            <th class="text-center">
                                                Item Name
                                            </th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">UOM</th>
                                            <th class="text-center">
                                                Amount Price
                                            </th>
                                            <th class="text-center">
                                                Total Amount
                                            </th>
                                            <th class="text-center">Notes</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(order,
                                            index) in orders_detail"
                                            v-bind:key="index"
                                        >
                                            <td>{{ order.skuid }}</td>
                                            <td>{{ order.item_name }}</td>
                                            <td>
                                                <input
                                                    v-model="order.qty"
                                                    type="number"
                                                    placeholder="Qty"
                                                    min="0"
                                                    class="form-control qty"
                                                    v-on:input="
                                                        calculateTotalAmount(
                                                            index
                                                        )
                                                    "
                                                />
                                            </td>
                                            <td>{{ order.uom_name }}</td>
                                            <td style="text-align: right;">
                                                {{
                                                    formatPrice(
                                                        order.amount_price
                                                    )
                                                }}
                                            </td>
                                            <td style="text-align: right;">
                                                {{
                                                    formatPrice(
                                                        order.total_amount
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                <input
                                                    v-model="order.notes"
                                                    type="text"
                                                    placeholder="Notes"
                                                    class="form-control"
                                                />
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-icon btn-sm btn-danger"
                                                    @click="
                                                        removeOrderDetails(
                                                            index
                                                        )
                                                    "
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td
                                                colspan="5"
                                                style="text-align: right;"
                                            >
                                                Grand Total
                                            </td>
                                            <td style="text-align: right;">
                                                {{ totalItem }}
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Remarks</b></label>
                                <textarea
                                    v-bind:class="{
                                        'is-invalid': errors.remark
                                    }"
                                    v-model="sales_order.remark"
                                    class="form-control"
                                    id="Remarks"
                                    name="Remarks"
                                ></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card-body">
                                <button
                                    class="btn btn-danger"
                                    v-on:click="submitForm()"
                                >
                                    Submit
                                </button>
                                <button
                                    class="btn btn-secondary"
                                    type="button"
                                    onClick="history.back()"
                                >
                                    Back
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center p-4 text-muted" v-else>
                        <h5>Loading</h5>
                        <p>Please wait, data is being loaded...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ModelListSelect } from "vue-search-select";

export default {
    data() {
        return {
            sales_order: {},
            qty: [0],
            skuid: "",
            total_amount: [0],
            source_orders: [],
            orders_detail: [],
            item: {},
            items: [],
            notes: [],
            errors: [],
            customers: [],
            loading: false
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/marketing/sales_order/" +
                            this.$route.params.id +
                            "/edit"
                    )
                )
                .then(res => {
                    this.sales_order = res.data.sales_order;
                    this.orders_detail =
                        res.data.sales_order.sales_order_details;
                    this.items = res.data.items;
                    this.qty = [0];
                    this.total_amount = [0];
                    this.loading = true;
                    console.log("res : ", res.data);
                })
                .catch(err => {
                    console.error(err);
                    if (err.response.status === 500) {
                        this.getData();
                    }
                });
        },
        formatPrice(value) {
            return Number.parseInt(value).toLocaleString("id-ID", {
                minimumFractionDigits: 2
            });
        },
        getItem() {
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/master_data/price/" +
                            this.sales_order.customer_id +
                            "/" +
                            this.skuid +
                            "/" +
                            this.sales_order.fulfillment_date
                    )
                )
                .then(res => {
                    this.item = res.data.data;
                })
                .catch(err => {});
        },
        calculateTotalAmount(index) {
            this.orders_detail[index].total_amount =
                this.orders_detail[index].qty *
                this.orders_detail[index].amount_price;
        },
        pushOrderDetails(skuid) {
            if (!skuid) return;
            let index = this.orders_detail.length;
            const indexItem = this.orders_detail.findIndex(
                x => x.skuid === skuid
            );
            if (indexItem >= 0) {
                Vue.swal({
                    type: "error",
                    title: "ERROR!",
                    text: "Item Already Added!"
                });
            } else {
                return this.orders_detail.push({
                    skuid: this.item.skuid,
                    qty: 0,
                    total_amount: 0,
                    uom_name: this.item.uom,
                    uom_id: this.item.uom_id,
                    item_name: this.item.item_name,
                    amount_price: this.item.amount,
                    notes: null
                });
            }
        },
        //Remove Detail Order
        // removeOrderDetails(orderId, index) {
        //     Vue.swal({
        //         title: "Are you sure?",
        //         text:
        //             "The item and their associated data will be permanently deleted. Proceed?",
        //         type: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Yes!"
        //     })
        //         .then(result => {
        //             if (result.value) {
        //                 axios
        //                     .delete(
        //                         this.$parent.MakeUrl(
        //                             "api/v1/marketing/sales_order/detail/" +
        //                                 orderId
        //                         )
        //                     )
        //                     .then(res => {
        //                         this.orders_detail.splice(index, 1);
        //                         this.getData();
        //                         console.log(res.data);
        //                     })
        //                     .catch(err => {
        //                         console.error(err);
        //                     });
        //             }
        //         })
        //         .catch(error => {
        //             console.error(error);
        //         });
        // },
        removeOrderDetails(index) {
            this.orders_detail.splice(index, 1);
        },

        async submitForm() {
            const payload = {
                customerId: this.sales_order.customer_id,
                salesOrderId: this.sales_order.id,
                remark: this.sales_order.remark,
                items: this.orders_detail.map((item, idx) => ({
                    order_details_id: item.id,
                    skuid: item.skuid,
                    amount_price: item.amount_price,
                    uom_id: item.uom_id,
                    qty: item.qty,
                    notes: item.notes
                }))
            };
            console.log(payload);
            try {
                const res = await axios.patch(
                    this.$parent.MakeUrl("api/v1/marketing/sales_order/update"),
                    payload
                );
                Vue.swal({
                    type: "success",
                    title: "Success!",
                    text: "Successfully Insert Data!"
                }).then(next => {
                    this.$router.push({ name: "form_sales_order" });
                });
                console.log(res);
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            }
        }
    },
    components: {
        ModelListSelect
    },
    computed: {
        totalItem: function() {
            let sum = 0;
            this.orders_detail.forEach(function(item) {
                sum += parseFloat(item.total_amount);
            });
            return sum.toLocaleString("id-ID", {
                minimumFractionDigits: 2
            });
        }
    }
};
</script>
