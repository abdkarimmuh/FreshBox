<template>
    <div class="row">
        <div class="col-12" v-if="loading">
            <div class="card col-12">
                <div class="card-header">
                    <h4 class="text-danger">Receive In/Out Payment</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <!-- Request Date -->
                        <s-form-input
                            col="3"
                            title="Request Date"
                            :model="requestAdvance.request_date"
                            disabled="true"
                        />
                        <!-- Request Type -->
                        <s-form-input
                            col="3"
                            title="Request Type"
                            :model="requestAdvance.request_type"
                            disabled="true"
                        />
                        <!--Product Types-->
                        <s-form-input
                            col="3"
                            title="Product Type"
                            :model="requestAdvance.product_type_name"
                            disabled="true"
                        />

                        <!--Product Types-->
                        <s-form-input
                            col="3"
                            title="Warehouse Address"
                            :model="requestAdvance.shipping_name"
                            disabled="true"
                        />

                        <s-form-input
                            col="3"
                            title="Name"
                            :model="requestAdvance.user_name"
                            disabled="true"
                        />

                        <s-form-input
                            col="3"
                            title="Dept"
                            :model="requestAdvance.dept"
                            disabled="true"
                        />

                        <s-form-input
                            col="3"
                            title="Bank Name"
                            :model="requestAdvance.bank_name"
                            disabled="true"
                        />

                        <s-form-input
                            col="3"
                            title="Bank Account"
                            :model="requestAdvance.bank_account"
                            disabled="true"
                        />

                        <div
                            class="col-md-3"
                            v-if="
                                requestAdvance.file_name !== '' &&
                                    requestAdvance.file_name !== null
                            "
                        >
                            <div class="form-group">
                                <label>
                                    <b>File</b>
                                </label>
                                <div>
                                    <a
                                        href="#"
                                        class="badge badge-info ml-1 mr-1 mt-1 mb-1"
                                        @click="
                                            showFile(requestAdvance.file_url)
                                        "
                                    >
                                        {{ requestAdvance.file_name }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="table-responsive" style="clear: both;">
                                <table
                                    class="table table-hover"
                                    style="font-size: 9pt;"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">
                                                Item Name
                                            </th>
                                            <th class="text-center">
                                                Item Type
                                            </th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Uom</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">PPN(%)</th>
                                            <th class="text-center">PPH(%)</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">
                                                Suplier Name
                                            </th>
                                            <th class="text-center">
                                                Remark
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(item, index) in detail"
                                            v-bind:key="index"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ item.item_name }}</td>
                                            <td>{{ item.skuid }}</td>
                                            <td>{{ item.qty }}</td>
                                            <td>{{ item.uom_name }}</td>
                                            <td>{{ item.price }}</td>
                                            <td>{{ item.ppn }}</td>
                                            <td>
                                                <input
                                                    style="width: 80px;"
                                                    v-model="item.pph"
                                                    type="number"
                                                    class="form-control"
                                                    @change="updateTotalAmount"
                                                    min="0"
                                                />
                                            </td>
                                            <td>{{ item.total }}</td>
                                            <td>{{ item.supplier_name }}</td>
                                            <td>{{ item.remarks }}</td>
                                        </tr>
                                    </tbody>
                                </table>
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
            requestAdvance: {},
            detail: [],
            errors: [],
            loading: false,
            loadingSubmit: false,
            header: {}
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        /**
         * Get All Data
         * Customer | Source Order | Driver
         */
        getData() {
            this.loading = false;
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/finance-ap/request-advance/show/" +
                            this.$route.params.id
                    )
                )
                .then(res => {
                    this.requestAdvance = res.data.data;
                    this.detail = res.data.data.details;

                    this.loading = true;
                    console.log(res);
                })
                .catch(err => {
                    console.error(err);
                });
        },
        /**
         * Insert Sales Order
         */
        async submitForm() {
            this.loadingSubmit = true;
            const payload = {
                requestAdvance: this.requestAdvance,
                detail: this.detail
            };
            console.log(payload);
            try {
                const res = await axios.post(
                    this.$parent.MakeUrl(
                        "api/v1/finance-ap/in-out-payment/receive"
                    ),
                    payload
                );
                console.log(res);
                Vue.swal({
                    type: "success",
                    title: "Success!",
                    text: "Successfully Insert Data!"
                }).then(next => {
                    this.$router.push({ name: "finance.inOutPayment" });
                });
            } catch (e) {
                this.loadingSubmit = false;
                this.errors = e.response.data.errors;
                console.error(e.response.data);
            }
        },
        updateTotalAmount() {
            this.detail.map(
                (item, idx) =>
                    (item.total =
                        parseInt(item.price) +
                        (parseInt(item.price) * parseInt(item.ppn)) / 100 +
                        (parseInt(item.price) * parseInt(item.pph)) / 100)
            );
        },
        showFile(fileUrl, fileName) {
            Vue.swal({
                title: fileName,
                imageUrl: fileUrl,
                imageAlt: "Custom image"
            });
            console.log(fileUrl);
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
            this.detail.forEach(function(item) {
                sum += parseFloat(item.total);
            });

            return sum.toLocaleString("id-ID", {
                minimumFractionDigits: 2
            });
        }
    }
};
</script>
