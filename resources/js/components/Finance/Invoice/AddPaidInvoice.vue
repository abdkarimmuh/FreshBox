<template>
    <stisla-create-template title="Add Paid Invoice">
        <div class="row" v-if="loading">
            <div class="col-md-4">
                <div class="form-group">
                    <label>
                        <b>Rekap Invoice Order No</b>
                        <span style="color: red;">*</span>
                    </label>
                    <div>
                        <model-list-select
                            v-bind:class="{'is-invalid': errors.invoice_id}"
                            :list="recapInvoices"
                            v-model="recapInvoice.id"
                            v-on:input="getRecapInvoice"
                            option-value="id"
                            option-text="recapNoWithCustName"
                            placeholder="Select Recap Invoice Order No"
                        ></model-list-select>
                        <div style="margin-top: .25rem; font-size: 80%;color: #dc3545" v-if="errors.invoice_id">
                            <p>{{ errors.invoice_id[0] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Customer -->
            <s-form-input title="Customer" :model="recapInvoice.customer_name" disabled="true" col="4"
                          v-if="recapInvoice.id !== null">
            </s-form-input>
            <!--UP-->
            <s-form-input title="Up" :model="recapInvoice.up" disabled="true" col="4" v-if="recapInvoice.id !== null">
            </s-form-input>
            <!--Paid Date-->
            <div class="col-md-4" v-if="recapInvoice.id !== null">
                <div class="form-group">
                    <label>
                        <b>Paid Date</b>
                        <span style="color: red;">*</span>
                    </label>
                    <div>
                        <date-picker
                            v-model="recapInvoice.paidDate"
                            lang="en"
                            valueType="format"
                        ></date-picker>
                    </div>
                    <div
                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                        v-if="errors.do_date"
                    >
                        <p>{{ errors.do_date[0] }}</p>
                    </div>
                </div>
            </div>
            <!--                Choose File-->
            <div class="col-md-4" v-if="recapInvoice.id !== null">
                <div class="form-group">
                    <label>
                        <b>File</b>
                    </label>
                    <div class="custom-file">
                        <input
                            v-bind:class="{'is-invalid': errors.file}"
                            type="file"
                            class="custom-file-input"
                            v-on:change="onFileChange"
                        />
                        <label class="custom-file-label" v-if="fileName">
                            {{ fileName }}
                        </label>
                        <label class="custom-file-label" v-else>Choose File</label>
                        <div class="invalid-feedback" v-if="errors.file">
                            <p>{{ errors.file[0] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!--Total Amount-->
            <s-form-input title="Total Amount Price" :model="recapInvoice.total_amount | toIDR" disabled="true" col="4"
                          v-if="recapInvoice.id !== null">
            </s-form-input>

            <!--Total Amount Paid-->
            <s-form-input title="Total Amount Paid" :model="totalAmountPaid" disabled="true"
                          col="3"
                          v-if="recapInvoice.id !== null">
            </s-form-input>
            <!--Admin Amount-->

            <div class="col-md-3">
                <div class="form-group" v-if="recapInvoice.id !== null">
                    <label>
                        <b>Admin Amount</b>
                        <span style="color: red;">*</span>
                    </label>
                    <div>
                        <input type="text"
                               v-bind:class="{'is-invalid': errors.adminAmount}"
                               placeholder="Admin Amount"
                               class="form-control"
                               v-model="recapInvoice.adminAmount"
                               required/>
                        <div class="invalid-feedback" v-if="errors.adminAmount">
                            <p>{{ errors.adminAmount[0] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <s-form-input title="Final Amount" :model="finalAmount | toIDR" disabled="true"
                          col="3"
                          v-if="recapInvoice.id !== null">
            </s-form-input>
            <div v-if="recapInvoice.id !== null" class="col-12">
                <div class="table-responsive m-t-40" style="clear: both;">
                    <table class="table table-hover" style="font-size: 9pt;">
                        <thead>
                        <tr>
                            <th class="text-center">Invoice No</th>
                            <th class="text-center">Total Price</th>
                            <th class="text-center">Amount Paid</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(invoice, index) in invoices" v-bind:key="index">
                            <td>{{ invoice.invoice_no }}</td>
                            <td>{{ invoice.price | toIDR }}</td>
                            <td>
                                <input type="number" class="form-control" v-model="invoice.amountPaid"
                                       v-on:change="validateAmount(index)"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12" v-if="recapInvoice.id !== null">
                <div class="form-group">
                    <label>
                        <b>Remark</b>
                    </label>
                    <textarea
                        v-model="recapInvoice.remark"
                        class="form-control"
                    ></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="card-body">
                    <div v-if="loadingSubmit">
                        <loading-button/>
                    </div>
                    <div v-else>
                        <button class="btn btn-danger" v-on:click="submitForm()">
                            Submit
                        </button>
                        <back-button/>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <loading-table/>
        </div>
    </stisla-create-template>
</template>

<script>
    import {ModelListSelect} from "vue-search-select";
    import StislaCreateTemplate from "../../Template/StislaCreateTemplate";
    import StislaSearchSelect from "../../Template/StislaSearchSelect";
    import LoadingTable from "../../Template/Table/partials/LoadingTable";

    export default {
        data() {
            return {
                recapInvoice: {
                    id: null,
                    file: null,
                    adminAmount: null
                },
                fileName: null,
                recapInvoices: [],
                invoices: [],
                errors: [],
                loading: true,
                loadingSubmit: false
            };
        },
        mounted() {
            this.getRecapInvoices();
        },
        methods: {
            getRecapInvoices() {
                axios.get(this.$parent.MakeUrl('api/v1/finance/invoice_recap/submitted')).then(res => {
                    this.recapInvoices = res.data.data;
                })
            },
            getRecapInvoice() {
                this.loading = false;
                axios.get(this.$parent.MakeUrl('api/v1/finance/invoice_recap/show/' + this.recapInvoice.id))
                    .then(res => {
                        this.recapInvoice = res.data.data;
                        this.invoices = res.data.data.invoice_recap_detail;
                        this.loading = true;
                    }).catch(e => {
                })
            },
            async submitForm() {
                this.loadingSubmit = true;
                const payload = {
                    invoiceRecapId: this.recapInvoice.id,
                    file: this.recapInvoice.file,
                    paidDate: this.recapInvoice.paidDate,
                    invoiceRecapNo: this.recapInvoice.recap_invoice_no,
                    invoiceRecapDetail: this.invoices.map((item, idx) => ({
                        id: item.id,
                        amountPaid: item.amountPaid
                    }))
                };
                try {
                    const res = await axios.post("/api/v1/finance/invoice_recap/paid", payload);
                    Vue.swal({
                        type: "success",
                        title: "Success!",
                        text: "Successfully Insert Data!"
                    }).then(next => {
                        this.$router.push({name: 'paidRecap'})
                    });
                    console.log(res)
                } catch (e) {
                    this.loadingSubmit = false;
                    this.errors = e.response.data.errors;
                    console.error(e.response.data);
                }
            },
            onFileChange(e) {
                let fileData = e.target.files || e.dataTransfer.files;
                this.fileName = fileData[0].name;
                if (!fileData.length) return;
                this.createFile(fileData[0]);
                console.log(this.fileName)
            },
            createFile(file) {
                let reader = new FileReader();
                reader.onload = e => {
                    this.recapInvoice.file = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            validateAmount(idx) {
                let amountPaid = parseFloat(this.invoices[idx].amountPaid);
                let qty_so = parseFloat(this.invoices[idx].amountPaid) + (this.sales_order_details[idx].amountPaid * 0.1);
                if (qty_do > qty_so) {
                    this.qty_do[idx].qty = qty_so;
                }
            },
        },
        computed: {
            /**
             * Calculate Total Paid Price
             * @returns {string}
             */
            totalAmountPaid: function () {
                let sum = 0;
                this.invoices.forEach(function (item) {
                    sum += item.amountPaid ? parseFloat(item.amountPaid) : 0;
                });

                return sum.toLocaleString("id-ID", {
                    minimumFractionDigits: false
                });
            },
            finalAmount: function () {
                const finalAmount = this.recapInvoice.adminAmount ? Number(this.recapInvoice.total_amount) + Number(this.recapInvoice.adminAmount) : this.recapInvoice.total_amount;

                return finalAmount ;
            }
        },
        components: {
            LoadingTable,
            StislaSearchSelect,
            StislaCreateTemplate,
            ModelListSelect
        }
    };
</script>

