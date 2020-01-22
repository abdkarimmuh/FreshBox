<template>
    <div class="row">
        <div class="col-12" v-if="loading">
            <div class="card col-12">
                <div class="card-header">
                    <h4 class="text-danger">Confirm In/Out Payment</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>Payment Number</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <input
                                        type="text"
                                        v-bind:class="{
                                            'is-invalid': errors.no_payment
                                        }"
                                        placeholder="Payment Number"
                                        class="form-control"
                                        v-model="in_out_payment.no_payment"
                                        required
                                    />
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.no_payment"
                                    >
                                        <p>{{ errors.no_payment[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>Fillment Date</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <date-picker
                                        v-model="
                                            in_out_payment.confirm_date
                                        "
                                        lang="en"
                                        type="date"
                                        valuetype="format"
                                        :not-before="new Date()"
                                        format="YYYY-MM-DD"
                                    />
                                </div>
                                <div
                                    style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                    v-if="errors.confirm_date"
                                >
                                    <p>{{ errors.confirm_date[0] }}</p>
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="card-body">
                                <div v-if="loadingSubmit">
                                    <loading-button />
                                </div>
                                <div v-else>
                                    <button class="btn btn-danger" v-on:click="submitForm()">Submit</button>
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
            in_out_payment: {
                no_payment: '',
                confirm_date: ''
            },
            banks: [],
            types: [
                {
                    id: 2,
                    name: "IN"
                },
                {
                    id: 1,
                    name: "OUT"
                }
            ],
            errors: [],
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
                    axios.get(this.$parent.MakeUrl("api/v1/master_data/bank"))
                ])
                .then(
                    axios.spread(banks => {
                        this.banks = banks.data;
                        this.loading = true;
                    })
                )
                .catch(err => {
                    if (err.response.status === 403) {
                        this.$router.push({
                            name: "inOutPayment"
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
              no_payment: this.in_out_payment.no_payment,
              confirm_date: this.in_out_payment.confirm_date
            };
            console.log(payload);
            // try {
            //     const res = await axios.post(
            //         this.$parent.MakeUrl(
            //             "api/v1/finance-ap/in-out-payment/store"
            //         ),
            //         payload
            //     );
            //     console.log(res);
            //     Vue.swal({
            //         type: "success",
            //         title: "Success!",
            //         text: "Successfully Insert Data!"
            //     }).then(next => {
            //         this.$router.push({ name: "finance.inOutPayment" });
            //     });
            // } catch (e) {
            //     this.loadingSubmit = false;
            //     this.errors = e.response.data.errors;
            //     console.error(e.response.data);
            // }
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
                    this.items = res.data.price;
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
                return this.orders_detail.push({
                    total_amount: 0,
                    qty: 0,
                    skuid: this.item.skuid,
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
