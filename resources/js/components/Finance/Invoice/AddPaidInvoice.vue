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
                        <b>PAID Date</b>
                        <span style="color: red;">*</span>
                    </label>
                    <div>
                        <date-picker
                            v-model="recapInvoice.do_date"
                            lang="en"
                            valueType="format"
                            :not-before="new Date()"
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
            <!--Total Amount-->
            <s-form-input title="Total Amount Price" :model="recapInvoice.total_amount | toIDR" disabled="true" col="4"
                          v-if="recapInvoice.id !== null">
            </s-form-input>

            <div class="col-md-3" v-if="recapInvoice.id !== null">
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
                        <label class="custom-file-label" v-if="recapInvoice.fileName">
                            {{ recapInvoice.fileName }}
                        </label>
                        <label class="custom-file-label" v-else>Choose File</label>
                        <div
                            class="invalid-feedback"
                            v-if="errors.file"
                        >
                            <p>{{ errors.file[0] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="recapInvoice.id !== null" class="col-12">
                <div class="table-responsive m-t-40" style="clear: both;">
                    <table
                        class="table table-hover"
                        id="contentTable"
                        style="font-size: 9pt;"
                    >
                        <thead>
                        <tr>
                            <th class="text-center">Invoice No</th>
                            <th class="text-center">Total Price</th>
                            <th class="text-center">Paid Price</th>
                            <!--                            <th class="text-center">Paid Date</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(invoice, index) in invoices" v-bind:key="index">
                            <td>{{ invoice.invoice_no | toIDR }}</td>
                            <td>{{ invoice.price | toIDR }}</td>
                            <td>
                                <input type="number" class="form-control"/>
                            </td>
                            <!--                            <td>-->
                            <!--                                <input type="text" class="form-control"/>-->
                            <!--                            </td>-->
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
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
                    file: "",
                    fileName: null,
                },
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
                axios.get(this.$parent.MakeUrl('api/v1/finance/invoice_recap/listNotPaid')).then(res => {
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
                    user_id: this.recapInvoice.user_id,
                    sales_order_id: this.delivery_order.sales_order_id,
                    customer_id: this.delivery_order.customer_id,
                    do_date: this.delivery_order.do_date,
                    driver_id: this.delivery_order.driver_id,
                    pic_qc: this.delivery_order.pic_qc_id,
                    remark: this.delivery_order.remark,
                    so_details: this.sales_order_details.map((item, idx) => ({
                        id: item.id,
                        skuid: item.skuid,
                        uom_id: item.uom_id,
                        qty_do: this.qty_do[idx].qty
                    }))
                };
                try {
                    const res = await axios.post("/api/v1/warehouse/delivery_order", payload);
                    Vue.swal({
                        type: "success",
                        title: "Success!",
                        text: "Successfully Insert Data!"
                    }).then(next => {
                        window.location.href = "/admin/warehouse/delivery_order";
                    });
                } catch (e) {
                    this.loadingSubmit = false;
                    this.errors = e.response.data.errors;
                    console.error(e.response.data);
                }
            },
            onFileChange(e) {
                let fileData = e.target.files || e.dataTransfer.files;
                this.recapInvoice.fileName = fileData[0].name;
                if (!fileData.length) return;
                this.createFile(fileData[0]);
                console.log(this.recapInvoice.fileName)
            },

            createFile(file) {
                let reader = new FileReader();
                reader.onload = e => {
                    this.recapInvoice.file = e.target.result;
                };
                reader.readAsDataURL(file);
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

