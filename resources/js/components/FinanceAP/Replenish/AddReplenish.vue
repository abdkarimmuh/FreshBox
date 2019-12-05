<template>
    <stisla-create-template title="Add Finance Replenish">
        <div class="row" v-if="loading">
            <div class="col-md-12 text-center">
                <LoadingTable />
            </div>
        </div>
        <div class="row" v-else>
            <!-- Sales Order No -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <b>Select Procurement No</b>
                        <span style="color: red;">*</span>
                    </label>
                    <div>
                        <model-list-select
                            v-bind:class="{'is-invalid': errors.procurementId}"
                            :list="procurements"
                            v-model="procurementId"
                            v-on:input="getProcurement()"
                            option-value="id"
                            option-text="no_proc"
                            placeholder="Select Procurement No"
                        ></model-list-select>
                        <div
                            style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                            v-if="errors.procurementId"
                        >
                            <p>{{ errors.procurementId[0] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" v-if="procurementId !== ''">
                <div class="form-group">
                    <label>
                        <b>Status</b>
                        <span style="color: red;">*</span>
                    </label>
                    <select class="form-control selectric" v-model="status">
                        <option value="0" hidden>Select Status</option>
                        <option value="1">Replenish</option>
                        <option value="2">Return Replenish</option>
                    </select>
                </div>
            </div>
            <!-- User Proc -->
            <div class="col-md-3" v-if="procurementId !== ''">
                <div class="form-group">
                    <label>
                        <b>User Proc Name</b>
                    </label>
                    <div>
                        <input
                            type="text"
                            class="form-control"
                            v-model="procurement.proc_name"
                            disabled
                        />
                    </div>
                </div>
            </div>
            <!--Vendor Name-->
            <div class="col-md-3" v-if="procurementId !== ''">
                <div class="form-group">
                    <label>
                        <b>Vendor</b>
                    </label>
                    <div>
                        <input
                            type="text"
                            class="form-control"
                            v-model="procurement.vendor"
                            disabled
                        />
                    </div>
                </div>
            </div>
            <!--Total Amount-->
            <div class="col-md-3" v-if="procurementId !== ''">
                <div class="form-group">
                    <label>
                        <b>Total Amount</b>
                    </label>
                    <div>
                        <input
                            type="text"
                            class="form-control"
                            v-model="procurement.total_amount"
                            disabled
                        />
                    </div>
                </div>
            </div>
            <!--File-->
            <div class="col-md-3" v-if="procurementId !== ''">
                <div class="form-group">
                    <label>
                        <b>File</b>
                    </label>
                    <div>
                        <button
                            @click="showFile(procurement.file_url, procurement.file)"
                            class="badge badge-info"
                        >{{ procurement.file }}</button>
                    </div>
                </div>
            </div>
            <div v-if="procurementId !== ''" class="col-12">
                <div class="table-responsive m-t-40" style="clear: both;">
                    <table class="table table-hover" style="font-size: 9pt;">
                        <thead>
                            <tr>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">UOM</th>
                                <th class="text-center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in procurement.items" v-bind:key="index">
                                <td
                                    class="text-center"
                                    style="overflow:hidden; white-space:nowrap"
                                >{{ item.name }}</td>

                                <td
                                    class="text-center"
                                    style="overflow:hidden; white-space:nowrap"
                                >{{ item.qty }}</td>
                                <td
                                    class="text-center"
                                    style="overflow:hidden; white-space:nowrap"
                                >{{ item.uom }}</td>
                                <td
                                    class="text-center"
                                    style="overflow:hidden; white-space:nowrap"
                                >{{ item.amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12" v-if="procurementId !== ''">
                <div class="form-group">
                    <label>
                        <b>Remark</b>
                    </label>
                    <textarea v-model="procurement.remark" class="form-control"></textarea>
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
                            v-if="procurementId !== ''"
                        >Submit</button>
                        <back-button />
                    </div>
                </div>
            </div>
        </div>
    </stisla-create-template>
</template>

<script>
import { ModelListSelect } from "vue-search-select";
import StislaCreateTemplate from "../../Template/StislaCreateTemplate";
import LoadingTable from "../../Template/Table/partials/LoadingTable";

export default {
    data() {
        return {
            procurementId: "",
            status: 0,
            procurement: {},
            procurements: [],
            errors: [],
            loadingSubmit: false,
            loading: false
        };
    },
    mounted() {
        this.getProcurements();
    },
    methods: {
        getProcurements() {
            axios
                .get(this.$parent.MakeUrl("api/v1/procurement/confirmed"))
                .then(res => {
                    console.log(res);
                    this.procurements = res.data.data;
                })
                .catch(err => {
                    console.log(err);
                });
        },
        getProcurement() {
            this.loading = true;
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/procurement/show/" + this.procurementId
                    )
                )
                .then(res => {
                    console.log(res);
                    this.procurement = res.data.data;
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err);
                });
        },
        async submitForm() {
            this.loadingSubmit = true;
            const payload = {
                listProcId: this.procurementId,
                remark: this.procurement.remark,
                status: this.status,
                totalAmount: this.procurement.total_amount,
                userProcId: this.procurement.user_proc_id
            };
            try {
                const res = await axios.post(
                    "/api/v1/finance-ap/replenish/store",
                    payload
                );
                console.log(res);
                Vue.swal({
                    type: "success",
                    title: "Success!",
                    text: "Successfully Insert Data!"
                }).then(next => {
                    this.$router.push({ name: "finance.replenish" });
                });
            } catch (e) {
                this.errors = e.response.data.errors;
                console.error(e.response.data);
                this.loadingSubmit = false;
            }
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
        StislaCreateTemplate,
        ModelListSelect
    }
};
</script>

