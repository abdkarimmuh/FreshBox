<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12">
                <div class="card-header">
                    <h4 class="text-danger">Sales Order Details</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>Source Order</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        :list="source_orders"
                                        v-model="sales_order.sourceOrderId"
                                        option-value="id"
                                        option-text="name"
                                        placeholder="Select Source Order"
                                    ></model-list-select>
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.sourceOrderId"
                                    >
                                        <p>{{ errors.sourceOrderId[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div
                                class="form-group"
                                v-if="sales_order.sourceOrderId"
                            >
                                <label>
                                    <b>File</b>
                                </label>
                                <div class="custom-file">
                                    <input
                                        v-bind:class="{'is-invalid': errors.file}"
                                        type="file"
                                        name="site_logo"
                                        class="custom-file-input"
                                        id="site-logo"
                                        v-on:change="onFileChange"
                                    />
                                    <label class="custom-file-label">{{ sales_order.fileName ? sales_order.fileName :
                                        'Choose File'}}</label>
                                    <div
                                        class="invalid-feedback"
                                        v-if="errors.file"
                                    >
                                        <p>{{ errors.file[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div
                                class="form-group"
                                v-if="sales_order.sourceOrderId == 1"
                            >
                                <label>
                                    <b>No PO</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <input
                                        type="text"
                                        v-bind:class="{'is-invalid': errors.no_po}"
                                        placeholder="No PO"
                                        class="form-control"
                                        v-model="sales_order.no_po"
                                        required
                                    />
                                    <div
                                        class="invalid-feedback"
                                        v-if="errors.no_po"
                                    >
                                        <p>{{ errors.no_po[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>Customer</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-bind:class="{'is-invalid': errors.customerId}"
                                        :list="customers"
                                        v-model="sales_order.customerId"
                                        v-on:input="getData()"
                                        option-value="id"
                                        option-text="name"
                                        placeholder="Select Customer"
                                    ></model-list-select>
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.customerId"
                                    >
                                        <p>{{ errors.customerId[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>Fulfillment Date</b>
                                    <span style="color: red;">*</span>
                                </label>

                                <div>
                                    <date-picker
                                        v-model="sales_order.fulfillmentDate"
                                        lang="en"
                                        type="datetime"
                                        valueType="format"
                                        :not-before="new Date()"
                                        format="YYYY-MM-DD HH:mm:ss"
                                    ></date-picker>
                                </div>
                                <div
                                    style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                    v-if="errors.fulfillmentDate"
                                >
                                    <p>{{ errors.fulfillmentDate[0] }}</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-md-6"
                            v-if="sales_order.customerId != 0"
                        >
                            <div class="form-group">
                                <label>
                                    <b>Items</b>
                                    <span style="color: red;">*</span>
                                </label>

                                <model-list-select
                                    :list="items"
                                    v-model="skuid"
                                    v-on:input="getItems()"
                                    option-value="skuid"
                                    option-text="item_name"
                                    placeholder="Select Item"
                                >
                                </model-list-select>

                            </div>
                        </div>
                        <div
                            class="col-md-6 mt-4"
                            v-if="skuid != ''"
                        >
                            <div class="form-group">
                                <label></label>
                                <button
                                    class="btn btn-sm btn-primary"
                                    @click="pushOrderDetails(skuid)"
                                >Add Items
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
                        <div
                            v-if="sales_order.customerId != 0"
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
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">UOM</th>
                                        <th class="text-center">Amount Price</th>
                                        <th class="text-center">Total Amount</th>
                                        <th class="text-center">Notes</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="(orders, index) in orders_detail"
                                        v-bind:key="index"
                                    >
                                        <td>{{ orders.skuid }}</td>
                                        <td>{{ orders.item_name }}</td>
                                        <td style="text-align: right;">
                                            <input
                                                v-model="qty[index]"
                                                type="number"
                                                placeholder="Qty"
                                                min="0"
                                                oninput="validity.valid||(value='');"
                                                class="form-control qty"
                                            />
                                        </td>
                                        <td>{{ orders.uom }}</td>
                                        <td style="text-align: right;">{{ orders.amount | toIDR }}</td>
                                        <td style="text-align: right">{{ total_amount[index] | toIDR }}</td>
                                        <td>
                                            <input
                                                v-model="notes[index]"
                                                type="text"
                                                placeholder="Notes"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-icon btn-sm btn-danger"
                                                @click="removeOrderDetails(index)"
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
                                        >Grand Total
                                        </td>
                                        <td style="text-align: right;">{{ totalItem }}</td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div
                                v-for="(orders, index) in orders_detail"
                                v-bind:key="index"
                            >
                                <div
                                    style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                    v-if="errors[`items.${index}.qty`]"
                                >
                                    <p>The {{ orders_detail[index].item_name }} of qty field is required.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    <b>Remarks</b>
                                </label>
                                <textarea
                                    v-bind:class="{'is-invalid': errors.remark}"
                                    v-model="sales_order.remark"
                                    class="form-control"
                                    id="Remarks"
                                    name="Remarks"
                                ></textarea>
                                <div
                                    class="invalid-feedback"
                                    v-if="errors.remark"
                                >
                                    <p>{{ errors.remark[0] }}</p>
                                </div>
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
                                    @click="back()"
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
    import {
        ModelListSelect
    } from "vue-search-select";

    export default {
        data() {
            return {
                orders_detail: [],
                sales_order: {
                    user_id: UserID,
                    fulfillmentDate: "",
                    fileName: "",
                    file: "",
                    remark: "",
                    no_po: "",
                    customerId: 0,
                    sourceOrderId: 0,
                },
                skuid: "",
                qty: [0],
                total_amount: [0],
                source_orders: [],
                item: {},
                items: [],
                notes: [],
                errors: [],
                customers: [],
                loading: false,
                header: {}
            };
        },
        async mounted() {
            await this.getData();
        },
        methods: {
            /**
             * Get All Data
             * Customer | Source Order | Price
             */
            getData() {
                axios
                    .all([
                        axios.get(this.$parent.MakeUrl("api/v1/master_data/customer/list")),
                        axios.get(this.$parent.MakeUrl("api/v1/master_data/source_order/list")),
                        axios.get(this.$parent.MakeUrl("api/v1/master_data/price/customer/" + this.sales_order.customerId))
                    ])
                    .then(
                        axios.spread((customers, source_order, items) => {
                            this.customers = customers.data;
                            this.source_orders = source_order.data;
                            this.items = items.data.data;
                            this.orders_detail = [];
                            this.qty = [0];
                            this.total_amount = [0];
                            this.notes = [];
                            this.skuid = "";
                        })
                    )
                    .catch(err => {
                        if (err.response.status === 403) {
                            this.$router.push({
                                name: "form_sales_order"
                            });
                        }
                    });
            },
            /**
             * Insert Sales Order
             */
            async submitForm() {

                const payload = {
                    user_id: this.sales_order.user_id,
                    customerId: this.sales_order.customerId,
                    remark: this.sales_order.remark,
                    file: this.sales_order.file,
                    fulfillmentDate: this.sales_order.fulfillmentDate,
                    sourceOrderId: this.sales_order.sourceOrderId,
                    no_po: this.sales_order.no_po,
                    items: this.orders_detail.map((item, idx) => ({
                        skuid: item.skuid,
                        qty: this.qty[idx],
                        notes: this.notes[idx]
                    })),

                };

                try {
                    const res = await axios.post(this.$parent.MakeUrl("api/v1/marketing/sales_order/store"), payload);
                    Vue.swal({
                        type: "success",
                        title: "Success!",
                        text: "Successfully Insert Data!"
                    }).then(next => {
                        this.$router.push({name: 'form_sales_order'});
                    });

                } catch (e) {
                    this.errors = e.response.data.errors;
                }
            },

            onFileChange(e) {
                let fileData = e.target.files || e.dataTransfer.files;
                this.sales_order.fileName = fileData[0].name;
                if (!fileData.length) return;
                this.createFile(fileData[0]);
            },

            createFile(file) {
                let reader = new FileReader();
                reader.onload = e => {
                    this.sales_order.file = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            /**
             * Get List Items
             * @returns {number}
             */
            getItems() {
                axios.get(this.$parent.MakeUrl("api/v1/master_data/price/" + this.sales_order.customerId + "/" + this.skuid))
                    .then(res => {
                        this.item = res.data.data;
                    })
                    .catch(err => {
                    });
            },
            /**
             *
             * @param skuid
             * @returns {number}
             */
            pushOrderDetails(skuid) {
                if (!skuid) return;
                const indexItem = this.orders_detail.findIndex(x => x.skuid === skuid);
                if (indexItem >= 0) {
                    Vue.swal({
                        type: "error",
                        title: "ERROR!",
                        text: "Item Already Added!"
                    });
                    console.log("GAGAL");
                } else {
                    let index = this.orders_detail.length;
                    this.total_amount[index] = 0;
                    this.qty[index] = 0;
                    this.notes[index] = null;
                    return this.orders_detail.push({
                        skuid: this.item.skuid,
                        qty: 0,
                        uom: this.item.uom,
                        item_name: this.item.item_name,
                        amount: this.item.amount,
                        notes: null
                    });
                }
            },
            /**
             * Delete Item
             * @param index
             */
            removeOrderDetails(index) {
                this.orders_detail.splice(index, 1);
            },
            back() {
                this.$router.push({name: 'form_sales_order'});
            }
        },
        components: {
            ModelListSelect
        },
        computed: {
            /**
             * Calculate Total Item
             * @returns {string}
             */
            totalItem: function () {
                let sum = 0;
                this.total_amount.forEach(function (item) {
                    sum += parseFloat(item);
                });

                return sum.toLocaleString("id-ID", {
                    minimumFractionDigits: 2
                });
            }
        },
        watch: {
            /**
             * Calculate Total Amount Price
             * @param newQty
             * @param oldQty
             */
            qty: function (newQty, oldQty) {
                this.total_amount = this.orders_detail.map(
                    (item, idx) => item.amount * (newQty[idx] || 0)
                );
            }
        }
    };

</script>
