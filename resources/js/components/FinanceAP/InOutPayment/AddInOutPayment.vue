<template>
    <div class="row">
        <div class="col-12" v-if="loading">
            <div class="card col-12">
                <div class="card-header">
                    <h4 class="text-danger">Add a New In/Out Payment</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <b>Tipe Transaksi</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        :list="types"
                                        v-model="in_out_payment.type"
                                        option-value="id"
                                        option-text="name"
                                        v-on:input="getOptions()"
                                        placeholder="Select Tipe Transaksi"
                                    ></model-list-select>
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.type"
                                    >
                                        <p>{{ errors.type[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3" v-if="in_out_payment.type != ''">
                            <div class="form-group">
                                <label>
                                    <b>Opsi Transaksi</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        :list="options"
                                        v-model="in_out_payment.option"
                                        option-value="id"
                                        option-text="name"
                                        v-on:input="afterOption()"
                                        placeholder="Select Opsi Transaksi"
                                    ></model-list-select>
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.option"
                                    >
                                        <p>
                                            {{ errors.option[0] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" v-if="in_out_payment.option">
                            <div class="form-group">
                                <label>
                                    <b>Source Data</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        :list="no_requests"
                                        v-model="in_out_payment.source"
                                        v-if="
                                            in_out_payment.option == 1 &&
                                                no_requests != []
                                        "
                                        option-value="id"
                                        option-text="no_and_requester"
                                        v-on:input="getBank()"
                                        placeholder="Source Data"
                                    ></model-list-select>
                                    <input
                                        type="text"
                                        v-bind:class="{
                                            'is-invalid': errors.source
                                        }"
                                        v-else
                                        placeholder="Source Data"
                                        class="form-control"
                                        v-model="in_out_payment.source"
                                        required
                                    />
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.source"
                                    >
                                        <p>{{ errors.source[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" v-if="in_out_payment.option">
                            <div class="form-group">
                                <label>
                                    <b>Amount</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <input
                                        type="number"
                                        v-bind:class="{
                                            'is-invalid': errors.amount
                                        }"
                                        placeholder="Amount"
                                        class="form-control"
                                        v-model="in_out_payment.amount"
                                        required
                                    />
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.amount"
                                    >
                                        <p>{{ errors.amount[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" v-if="in_out_payment.option">
                            <div class="form-group">
                                <label>
                                    <b>Nama Bank</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-if="in_out_payment.type == 1"
                                        :list="bank_accounts"
                                        v-model="in_out_payment.bank_id"
                                        option-value="id"
                                        option-text="name"
                                        placeholder="Select Bank"
                                        v-on:input="getBankAccount()"
                                    ></model-list-select>
                                    <model-list-select
                                        v-else
                                        :list="banks"
                                        v-model="in_out_payment.bank_id"
                                        option-value="id"
                                        option-text="name"
                                        placeholder="Select Bank"
                                    ></model-list-select>
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.bank_id"
                                    >
                                        <p>{{ errors.bank_id[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3" v-if="in_out_payment.option">
                            <div class="form-group">
                                <label>
                                    <b>Request Date</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <date-picker
                                        v-model="
                                            in_out_payment.transaction_date
                                        "
                                        lang="en"
                                        type="date"
                                        valueType="format"
                                        :not-before="new Date()"
                                        format="YYYY-MM-DD"
                                    />
                                </div>
                                <div
                                    style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                    v-if="errors.transaction_date"
                                >
                                    <p>{{ errors.transaction_date[0] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3" v-if="in_out_payment.option">
                            <div class="form-group">
                                <label>
                                    <b>Nomor Rekening</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <input
                                        type="number"
                                        v-bind:class="{
                                            'is-invalid': errors.bank_account
                                        }"
                                        placeholder="Nomor Rekening"
                                        class="form-control"
                                        v-model="in_out_payment.bank_account"
                                        required
                                    />
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.bank_account"
                                    >
                                        <p>{{ errors.bank_account[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div
                                class="form-group"
                                v-if="in_out_payment.option"
                            >
                                <label>
                                    <b>File</b>
                                    <span
                                        style="color: red;"
                                        v-if="in_out_payment.option != 3"
                                        >*</span
                                    >
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
                                            in_out_payment.fileName
                                                ? in_out_payment.fileName
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

                        <div class="col-md-12" v-if="in_out_payment.option">
                            <div class="form-group">
                                <label>
                                    <b>Remarks</b>
                                </label>
                                <textarea
                                    v-bind:class="{
                                        'is-invalid': errors.remark
                                    }"
                                    v-model="in_out_payment.remark"
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
                                        v-if="
                                            in_out_payment.type != '' &&
                                                in_out_payment.option
                                        "
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
            in_out_payment: {
                type: "",
                option: "",
                source: "",
                transaction_date: "",
                bank_id: "",
                bank_account: "",
                amount: "",
                file: "",
                fileName: "",
                remark: ""
            },
            banks: [],
            bank_accounts: [],
            no_requests: [],
            types: [
                {
                    id: 1,
                    name: "In Payment"
                },
                {
                    id: 2,
                    name: "Out Payment"
                }
            ],
            options: [],
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
                    axios.get(this.$parent.MakeUrl("api/v1/master_data/bank")),
                    axios.get(
                        this.$parent.MakeUrl("api/v1/master_data/bank_account")
                    )
                ])
                .then(
                    axios.spread((banks, bank_accounts) => {
                        this.banks = banks.data;
                        this.bank_accounts = bank_accounts.data.data;
                        this.loading = true;
                    })
                )
                .catch(err => {
                    if (err.response.status === 403) {
                        this.$router.push({
                            name: "inOutPayment"
                        });
                    } else {
                        console.error(err);
                    }
                });
        },
        getOptions() {
            this.in_out_payment.option = "";
            this.options = "";
            this.getNoRequest();
            if (this.in_out_payment.type == 1) {
                this.options = [
                    {
                        id: 1,
                        name: "Setlement Advance"
                    },
                    {
                        id: 2,
                        name: "Replacement"
                    },
                    {
                        id: 3,
                        name: "General Income"
                    }
                ];
            } else {
                this.options = [
                    {
                        id: 1,
                        name: "Setlement Advance"
                    },
                    {
                        id: 2,
                        name: "Reimbursment"
                    },
                    {
                        id: 3,
                        name: "General Payment"
                    }
                ];
            }
        },
        afterOption() {
            this.in_out_payment.source = "";
            this.in_out_payment.bank_id = "";
            this.in_out_payment.bank_account = "";
            this.in_out_payment.amount = "";
            this.in_out_payment.fulfillmentDate = "";
            this.in_out_payment.file = "";
            this.in_out_payment.fileName = "";
            this.in_out_payment.remark = "";
        },
        getNoRequest() {
            this.no_requests = [];
            this.in_out_payment.source = "";
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/finance-ap/request-advance/get-no/" +
                            this.in_out_payment.type
                    )
                )
                .then(res => {
                    this.no_requests = res.data.data;
                    this.loading = true;
                    console.log(res);
                })
                .catch(err => {
                    if (err.response.status === 403) {
                        this.$router.push({
                            name: "inOutPayment"
                        });
                    } else {
                        console.error(err);
                    }
                });
        },
        getBank() {
            if (
                this.in_out_payment.type == 2 &&
                this.in_out_payment.option == 1
            ) {
                axios
                    .get(
                        this.$parent.MakeUrl(
                            "api/v1/finance-ap/request-advance/get-bank/" +
                                this.in_out_payment.source
                        )
                    )
                    .then(res => {
                        this.in_out_payment.bank_id = res.data.data.bank_id;
                        this.in_out_payment.bank_account =
                            res.data.data.bank_account;
                        this.loading = true;
                        console.log(res);
                    })
                    .catch(err => {
                        console.error(err);
                    });
            }
        },
        getBankAccount() {
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/finance-ap/request-advance/get-bank-account/" +
                            this.in_out_payment.bank_id
                    )
                )
                .then(res => {
                    this.in_out_payment.bank_account = res.data.data;
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
                type_transaction: this.in_out_payment.type,
                option_transaction: this.in_out_payment.option,
                source: this.in_out_payment.source,
                transaction_date: this.in_out_payment.transaction_date,
                bank_id: this.in_out_payment.bank_id,
                bank_account: this.in_out_payment.bank_account,
                amount: this.in_out_payment.amount,
                file: this.in_out_payment.file,
                remark: this.in_out_payment.remark
            };
            console.log(payload);
            try {
                const res = await axios.post(
                    this.$parent.MakeUrl(
                        "api/v1/finance-ap/in-out-payment/store"
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

        onFileChange(e) {
            let fileData = e.target.files || e.dataTransfer.files;
            this.in_out_payment.fileName = fileData[0].name;
            if (!fileData.length) return;
            this.createFile(fileData[0]);
        },

        createFile(file) {
            let reader = new FileReader();
            reader.onload = e => {
                this.in_out_payment.file = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        back() {
            this.$router.push({ name: "form_in_out_payment" });
        },
        resetField() {
            this.in_out_payment.fulfillmentDate = "";
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
