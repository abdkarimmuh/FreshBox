<template>
    <div class="row">
        <div class="col-12" v-if="loading">
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
                                        v-bind:class="{
                                            'is-invalid': errors.file
                                        }"
                                        type="file"
                                        name="site_logo"
                                        class="custom-file-input"
                                        id="site-logo"
                                        v-on:change="onFileChange"
                                    />
                                    <label class="custom-file-label">
                                        {{
                                            sales_order.fileName
                                                ? sales_order.fileName
                                                : "Choose File"
                                        }}
                                    </label>
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
                                v-if="sales_order.sourceOrderId === 1"
                            >
                                <label>
                                    <b>No PO</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <input
                                        type="text"
                                        v-bind:class="{
                                            'is-invalid': errors.no_po
                                        }"
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
                                        v-bind:class="{
                                            'is-invalid': errors.customerId
                                        }"
                                        :list="customers"
                                        v-on:input="resetField"
                                        v-model="sales_order.customerId"
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
                        <!--Fulfillment Date-->
                        <div
                            class="col-md-3"
                            v-if="sales_order.customerId !== 0"
                        >
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
                                        v-on:input="getItems()"
                                        valueType="format"
                                        :not-before="new Date()"
                                        format="YYYY-MM-DD HH:mm:ss"
                                    />
                                </div>
                                <div
                                    style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                    v-if="errors.fulfillmentDate"
                                >
                                    <p>{{ errors.fulfillmentDate[0] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <b>Driver</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-bind:class="{
                                            'is-invalid': errors.driver_id
                                        }"
                                        :list="drivers"
                                        v-model="sales_order.driver_id"
                                        option-value="id"
                                        option-text="name"
                                        placeholder="Select Driver"
                                    ></model-list-select>
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.driver_id"
                                    >
                                        <p>{{ errors.driver_id[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Items-->
                        <div
                            class="col-md-6"
                            v-if="sales_order.fulfillmentDate !== ''"
                        >
                            <div class="form-group">
                                <label>
                                    <b>Items</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <model-list-select
                                    :list="items"
                                    v-model="skuid"
                                    v-on:input="getItem"
                                    option-value="skuid"
                                    option-text="item_name"
                                    placeholder="Select Item"
                                ></model-list-select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4" v-if="skuid != ''">
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
                        <div v-if="sales_order.customerId !== 0" class="col-12">
                            <div
                                class="table-responsive m-t-40"
                                style="clear: both;"
                            >
                                <table
                                    class="table table-hover"
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
                                            track-by="index"
                                            v-bind:key="index"
                                        >
                                            <td>{{ order.skuid }}</td>
                                            <td>{{ order.item_name }}</td>
                                            <td style="text-align: right;">
                                                <input
                                                    v-model="order.qty"
                                                    type="number"
                                                    placeholder="Qty"
                                                    @change="updateTotalAmount"
                                                    min="0"
                                                    class="form-control qty"
                                                />
                                            </td>
                                            <td>{{ order.uom }}</td>
                                            <td style="text-align: right;">
                                                {{ order.amount | toIDR }}
                                            </td>
                                            <td style="text-align: right">
                                                {{ order.total_amount | toIDR }}
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
                            <div
                                v-for="(orders, index) in orders_detail"
                                v-bind:key="index"
                            >
                                <div
                                    style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                    v-if="errors[`items.${index}.qty`]"
                                >
                                    <p>
                                        The
                                        {{ orders_detail[index].item_name }} of
                                        qty field is required.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    <b>Remarks</b>
                                </label>
                                <textarea
                                    v-bind:class="{
                                        'is-invalid': errors.remark
                                    }"
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
                                <div v-if="loadingSubmit">
                                    <loading-button />
                                </div>
                                <div v-else>
                                    <button
                                        class="btn btn-danger"
                                        v-on:click="submitForm()"
                                    >
                                        Submit
                                    </button>
                                    <back-button />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12" v-else>
            <loading-table></loading-table>
        </div>
    </div>
</template>

<script>
import { ModelListSelect } from "vue-search-select";
import LoadingTable from "../../Template/Table/partials/LoadingTable";

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
                driver_id: 0,
                sourceOrderId: 0
            },
            skuid: null,
            source_orders: [],
            item: {},
            items: [],
            errors: [],
            customers: [],
            drivers: [],
            loading: false,
            loadingSubmit: false,
            header: {}
        };
    },
    async mounted() {
        await this.getData();
    },
    methods: {
        /**
         * Get All Data
         * Customer | Source Order | Driver
         */
        getData() {
            axios
                .all([
                    axios.get(
                        this.$parent.MakeUrl("api/v1/master_data/customer/list")
                    ),
                    axios.get(
                        this.$parent.MakeUrl(
                            "api/v1/master_data/source_order/list"
                        )
                    ),
                    axios.get(
                        this.$parent.MakeUrl("api/v1/master_data/driver/driver")
                    )
                ])
                .then(
                    axios.spread((customers, source_order, drivers) => {
                        this.customers = customers.data.data;
                        this.source_orders = source_order.data;
                        this.orders_detail = [];
                        this.skuid = "";
                        this.drivers = drivers.data;
                        this.loading = true;
                    })
                )
                .catch(err => {
                    if (err.response.status === 403) {
                        this.$router.push({
                            name: "form_sales_order"
                        });
                    }
                    if (err.response.status === 500) {
                        this.getData();
                    }
                });
        },
        /**
         * Insert Sales Order
         */
        async submitForm() {
            this.loadingSubmit = true;
            const payload = {
                user_id: this.sales_order.user_id,
                customerId: this.sales_order.customerId,
                remark: this.sales_order.remark,
                file: this.sales_order.file,
                fulfillmentDate: this.sales_order.fulfillmentDate,
                sourceOrderId: this.sales_order.sourceOrderId,
                no_po: this.sales_order.no_po,
                driver_id: this.sales_order.driver_id,
                items: this.orders_detail.map((item, idx) => ({
                    skuid: item.skuid,
                    qty: item.qty,
                    notes: item.notes,
                    uom_id: item.uom_id
                }))
            };

            console.log("payload : ", payload);

            try {
                const res = await axios.post(
                    this.$parent.MakeUrl("api/v1/marketing/sales_order/store"),
                    payload
                );
                Vue.swal({
                    type: "success",
                    title: "Success!",
                    text: "Successfully Insert Data!"
                }).then(next => {
                    this.$router.push({ name: "form_sales_order" });
                });
            } catch (e) {
                this.loadingSubmit = false;
                this.errors = e.response.data.errors;
                console.error(e.response.data);
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
            this.loading = false;
            console.log(this.sales_order.fulfillmentDate);
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/master_data/price/customer/" +
                            this.sales_order.customerId +
                            "/" +
                            this.sales_order.fulfillmentDate
                    )
                )
                .then(res => {
                    console.log("price : ", res.data);
                    this.items = res.data.data;
                    this.orders_detail = [];
                    this.loading = true;
                })
                .catch(err => {
                    if (err.response.status === 500) {
                        this.getItems();
                    }
                });
        },
        getItem() {
            if (!this.skuid) return;
            this.loading = false;
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/master_data/price/" +
                            this.sales_order.customerId +
                            "/" +
                            this.skuid
                    )
                )
                .then(res => {
                    this.item = res.data.data;
                    this.loading = true;
                })
                .catch(err => {
                    if (err.response.status === 500) {
                        this.getItem();
                    }
                });
        },
        /**
         *
         * @param skuid
         * @returns {number}
         */
        pushOrderDetails(skuid) {
            if (!skuid) return;
            const indexItem = this.orders_detail.findIndex(
                x => x.skuid === skuid
            );
            if (indexItem >= 0) {
                Vue.swal({
                    type: "error",
                    title: "ERROR!",
                    text: "Item Already Added!"
                });
                console.log("GAGAL");
            } else {
                console.log("Order Detail : ", this.orders_detail);
                return this.orders_detail.push({
                    total_amount: 0,
                    qty: 0,
                    skuid: this.item.skuid,
                    uom: this.item.uom,
                    uom_id: this.item.uom_id,
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
            this.$router.push({ name: "form_sales_order" });
        },
        updateTotalAmount() {
            this.orders_detail.map(
                (item, idx) => (item.total_amount = item.amount * item.qty)
            );
        },
        resetField() {
            this.sales_order.fulfillmentDate = "";
        }
    },
    components: {
        LoadingTable,
        ModelListSelect
    },
    computed: {
        /**
         * Calculate Total Item
         * @returns {string}
         */
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
