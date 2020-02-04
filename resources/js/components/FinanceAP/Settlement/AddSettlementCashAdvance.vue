<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12" v-if="!loading">
                <div class="card-header">
                    <h4 class="text-danger">Create Settlement</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <!-- Request Finance -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <b>No Request</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-bind:class="{
                                            'is-invalid': errors.requestId
                                        }"
                                        :list="requestAdvances"
                                        v-model="requestId"
                                        v-on:input="getRequest()"
                                        option-value="id"
                                        option-text="no_request"
                                        placeholder="Select No Request"
                                    />
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.requestId"
                                    >
                                        <p>{{ errors.requestId[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <s-form-input
                            col="3"
                            title="Request Date"
                            :model="requestAdvance.request_date"
                            disabled="true"
                            v-if="requestId !== ''"
                        />

                        <s-form-input
                            col="2"
                            title="Request Type"
                            :model="requestAdvance.request_type"
                            disabled="true"
                            v-if="requestId !== ''"
                        />

                        <s-form-input
                            col="2"
                            title="Product Type"
                            :model="requestAdvance.product_type_name"
                            disabled="true"
                            v-if="requestId !== ''"
                        />

                        <s-form-input
                            col="2"
                            title="Warehouse Address"
                            :model="requestAdvance.shipping_name"
                            disabled="true"
                            v-if="requestId !== ''"
                        />

                        <s-form-input
                            col="2"
                            title="Name"
                            :model="user.name"
                            disabled="true"
                            v-if="requestId !== ''"
                        />

                        <s-form-input
                            col="2"
                            title="Dept"
                            :model="user.dept"
                            disabled="true"
                            v-if="requestId !== ''"
                        />

                        <s-form-input
                            col="2"
                            title="Nama Rekening"
                            :model="user.bank_name"
                            disabled="true"
                            v-if="requestId !== ''"
                        />

                        <s-form-input
                            col="3"
                            title="Nomor Rekening"
                            :model="user.bank_account"
                            disabled="true"
                            v-if="requestId !== ''"
                        />

                        <div class="col-md-3" v-if="requestId !== ''">
                            <div class="form-group">
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
                                            fileName ? fileName : "Choose File"
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

                        <div
                            class="col-12"
                            style="margin-top:50px;"
                            v-if="requestId !== ''"
                        >
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
                                            <th class="text-center">
                                                Qty Confirm
                                                <span style="color: red;"
                                                    >*</span
                                                >
                                            </th>
                                            <th class="text-center">Uom</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">
                                                Price Confirm
                                                <span style="color: red;"
                                                    >*</span
                                                >
                                            </th>
                                            <th class="text-center">PPN(%)</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">
                                                Total Confirm
                                                <span style="color: red;"
                                                    >*</span
                                                >
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(item, index) in details"
                                            v-bind:key="index"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ item.item_name }}</td>
                                            <td>{{ item.skuid }}</td>
                                            <td>{{ item.qty }}</td>
                                            <td>
                                                <input
                                                    v-model="item.qty_confirm"
                                                    type="number"
                                                    class="form-control"
                                                    min="0"
                                                />
                                            </td>
                                            <td>{{ item.uom_name }}</td>
                                            <td>{{ item.price }}</td>
                                            <td>
                                                <input
                                                    v-model="item.price_confirm"
                                                    type="number"
                                                    class="form-control"
                                                    @change="updateTotalAmount"
                                                    min="0"
                                                />
                                            </td>
                                            <td>{{ item.ppn }}</td>
                                            <td>{{ item.total }}</td>
                                            <td>{{ item.total_confirm }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12" v-if="requestId !== ''">
                            <div class="form-group">
                                <label>
                                    <b>Remarks</b>
                                </label>
                                <textarea
                                    v-bind:class="{
                                        'is-invalid': errors.remarks
                                    }"
                                    v-model="remarks"
                                    class="form-control"
                                    id="Remarks"
                                    name="Remarks"
                                ></textarea>
                                <div
                                    class="invalid-feedback"
                                    v-if="errors.remarks"
                                >
                                    <p>{{ errors.remarks[0] }}</p>
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
                                        v-if="requestId !== ''"
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
            <div class="card col-12" v-else>
                <loading-table />
            </div>
        </div>
    </div>
</template>
<script>
import { ModelListSelect } from "vue-search-select";

export default {
    data() {
        return {
            user: {},
            requestId: "",
            remarks: "",
            fileName: "",
            file: "",
            errors: [],
            details: [],
            loading: false,
            loadingSubmit: false,
            requestAdvance: {},
            requestAdvances: []
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        async submitForm() {
            this.loadingSubmit = true;
            const payload = {
                requestId: this.requestId,
                file: this.file,
                remarks: this.remarks,
                items: this.details.map((item, idx) => ({
                    id: item.id,
                    qty_confirm: item.qty_confirm,
                    price_confirm: item.price_confirm,
                    total_confirm: item.total_confirm
                }))
            };
            console.log(payload);
            try {
                const res = await axios.post(
                    "/api/v1/finance-ap/settlement-cash-advance",
                    payload
                );
                Vue.swal({
                    type: "success",
                    title: "Success!",
                    text: "Successfully Insert Data!"
                }).then(next => {
                    this.$router.push({ name: "finance.settlementFinance" });
                });
                console.log(res);
            } catch (e) {
                this.loadingSubmit = false;
                this.errors = e.response.data.errors;
                console.error(e.response.data);
            }
        },

        //Get Data Users & Items
        getData() {
            this.loading = true;
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/finance-ap/request-advance/get-settlement"
                    )
                )
                .then(res => {
                    this.requestAdvances = res.data.data;
                    this.loading = false;
                    console.log(res);
                })
                .catch(err => {
                    if (err.response.status === 500) {
                        this.getData();
                    }
                });
        },
        getRequest() {
            this.loading = true;
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/finance-ap/request-advance/show/" +
                            this.requestId
                    )
                )
                .then(res => {
                    this.requestAdvance = res.data.data;
                    this.details = res.data.data.details;
                    this.loading = false;
                    this.getUser(this.requestAdvance.user_id);
                    console.log(res);
                })
                .catch(err => {
                    console.error(err);
                });
        },
        getUser(userId) {
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/master_data/users/getUserVendor/" + userId
                    )
                )
                .then(res => {
                    this.user = res.data.data;
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        updateTotalAmount() {
            this.details.map(
                (item, idx) =>
                    (item.total_confirm =
                        parseInt(item.price_confirm) +
                        (parseInt(item.price_confirm) * parseInt(item.ppn)) /
                            100)
            );
        },
        onFileChange(e) {
            let fileData = e.target.files || e.dataTransfer.files;
            this.fileName = fileData[0].name;
            if (!fileData.length) return;
            this.createFile(fileData[0]);
        },

        createFile(file) {
            let reader = new FileReader();
            reader.onload = e => {
                this.file = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    },
    components: {
        ModelListSelect
    }
};
</script>
