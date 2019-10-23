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
                        <div
                            style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                            v-if="errors.invoice_id"
                        >
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
                        <b>Submit Date</b>
                        <span style="color: red;">*</span>
                    </label>
                    <div>
                        <date-picker
                            v-model="submitDate"
                            lang="en"
                            valueType="format"
                            :not-before="new Date()"
                        ></date-picker>
                    </div>
                    <div
                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                        v-if="errors.submitDate"
                    >
                        <p>{{ errors.submitDate[0] }}</p>
                    </div>
                </div>
            </div>
            <!--Total Amount-->
            <s-form-input title="Total Amount Price" :model="recapInvoice.total_amount | toIDR" disabled="true" col="4"
                          v-if="recapInvoice.id !== null">
            </s-form-input>


            <div v-if="recapInvoice.id !== null" class="col-12">
                <div class="table-responsive m-t-40" style="clear: both;">
                    <table class="table table-bordered table-md">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th class="text-left">Invoice No</th>
                            <th class="text-left">Total Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(invoice, index) in invoices" v-bind:key="index">
                            <td>{{ index + 1}}</td>
                            <td class="text-left">{{ invoice.invoice_no | toIDR }}</td>
                            <td class="text-left">{{ invoice.price | toIDR }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-12" v-if="recapInvoice.id !== null">
                <div class="card-body">
                    <div v-if="loadingSubmit">
                        <button-loading></button-loading>
                    </div>
                    <div v-else>
                        <button
                            class="btn btn-danger"
                            v-on:click="submitForm()"
                        >Submit
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            onclick="history.back()"
                        >Back
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <div v-else>
            <loading-table></loading-table>
        </div>
    </stisla-create-template>
</template>

<script>
    import {ModelListSelect} from "vue-search-select";
    import StislaCreateTemplate from "../../Template/StislaCreateTemplate";
    import StislaSearchSelect from "../../Template/StislaSearchSelect";
    import LoadingTable from "../../Template/Table/partials/LoadingTable";
    import ButtonLoading from "../../Template/Etc/ButtonLoading";

    export default {
        data() {
            return {
                recapInvoice: {
                    id: null,
                },
                submitDate: '',
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
                axios.get(this.$parent.MakeUrl('api/v1/finance/invoice_recap/notSubmitted')).then(res => {
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
                    recapInvoiceId: this.recapInvoice.id,
                    submitDate: this.submitDate
                };
                try {
                    const res = await axios.post(this.$parent.MakeUrl('api/v1/finance/invoice_recap/submitted'), payload);
                    console.log(res);
                    Vue.swal({
                        type: "success",
                        title: "Success!",
                        text: "Successfully Insert Data!"
                    }).then(next => {
                        this.$router.push({name: 'submitRecap'});
                    });
                } catch (e) {
                    this.loadingSubmit = false;
                    this.errors = e.response.data.errors;
                    console.error(e.response.data);
                }
            },
        },
        components: {
            ButtonLoading,
            LoadingTable,
            StislaSearchSelect,
            StislaCreateTemplate,
            ModelListSelect
        }
    };
</script>

