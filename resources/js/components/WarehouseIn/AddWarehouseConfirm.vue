<template>
    <stisla-create-template title="Add Warehouse Confirm">
        <div class="row" v-if="loading">
            <div class="col-md-12 text-center">
                <LoadingTable></LoadingTable>
            </div>
        </div>
        <div class="row" v-else>
            <!-- Sales Order No -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <b>Procurement No</b>
                        <span style="color: red;">*</span>
                    </label>
                    <div>
                        <model-list-select
                            v-bind:class="{
                                'is-invalid': errors.procurementId
                            }"
                            :list="procurements"
                            v-model="procurementId"
                            v-on:input="getProcurement()"
                            option-value="id"
                            option-text="no_proc_name"
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
            <div class="col-md-3" v-if="procurementId !== ''">
                <div class="form-group">
                    <label>
                        <b>User Proc Name</b>
                        <span style="color: red;">*</span>
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
            <!--File-->
            <div class="col-md-3" v-if="procurementId !== ''">
                <div class="form-group">
                    <label>
                        <b>File</b>
                    </label>
                    <div>
                        <image-modal
                            :file-url="procurement.file_url"
                            :file-name="procurement.file"
                        ></image-modal>
                    </div>
                </div>
            </div>

            <div v-if="procurementId !== ''" class="col-12">
                <div class="table-responsive m-t-40" style="clear: both;">
                    <table
                        class="table table-hover"
                        id="contentTable"
                        style="font-size: 9pt;"
                    >
                        <thead>
                            <tr>
                                <th style="overflow:hidden; white-space:nowrap">
                                    Item Name
                                </th>
                                <th
                                    class="text-center"
                                    style="overflow:hidden; white-space:nowrap"
                                >
                                    Qty Assign
                                </th>
                                <th class="text-center">UOM Assign</th>
                                <th
                                    class="text-center"
                                    style="overflow:hidden; white-space:nowrap"
                                >
                                    Qty Buy
                                </th>
                                <th class="text-center">UOM Buy</th>
                                <th class="text-center">Berat Kotor</th>
                                <th class="text-center">Berat Bersih</th>
                                <th class="text-center">Qty Reject</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in procurement.items"
                                v-bind:key="index"
                            >
                                <td style="overflow:hidden; white-space:nowrap">
                                    {{ item.name }}
                                </td>
                                <td class="text-center">
                                    {{ item.qty_assign }}
                                </td>
                                <td class="text-center">
                                    {{ item.uom_assign }}
                                </td>
                                <td class="text-center">{{ item.qty }}</td>
                                <td class="text-center">{{ item.uom }}</td>
                                <td>
                                    <input
                                        v-model="item.bruto"
                                        type="number"
                                        class="form-control"
                                    />
                                </td>
                                <td>
                                    <input
                                        v-model="item.netto"
                                        type="number"
                                        class="form-control"
                                    />
                                </td>
                                <td>
                                    <input
                                        v-model="item.qty_minus"
                                        type="number"
                                        class="form-control"
                                        min="0"
                                    />
                                </td>
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
                    <textarea
                        v-model="procurement.remark"
                        class="form-control"
                    ></textarea>
                </div>
            </div>
            <div class="col-12" v-if="procurementId !== ''">
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
                        <button
                            type="button"
                            class="btn btn-secondary"
                            onclick="history.back()"
                        >
                            Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </stisla-create-template>
</template>
<script>
import { ModelListSelect } from "vue-search-select";
import StislaCreateTemplate from "../Template/StislaCreateTemplate";
import LoadingTable from "../Template/Table/partials/LoadingTable";

export default {
    data() {
        return {
            procurementId: "",
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
                .get(this.$parent.MakeUrl("api/v1/procurement/not-confirmed"))
                .then(res => {
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
                procurementId: this.procurementId,
                userProcId: this.procurement.user_proc_id,
                remark: this.procurement.remark,
                items: this.procurement.items.map((item, idx) => ({
                    id: item.id,
                    bruto: item.bruto,
                    netto: item.netto,
                    tara: item.tara,
                    qty_minus: item.qty_minus
                }))
            };
            try {
                const res = await axios.post(
                    "/api/v1/warehouseIn/confirm/store",
                    payload
                );
                Vue.swal({
                    type: "success",
                    title: "Success!",
                    text: "Successfully Insert Data!"
                }).then(next => {
                    window.location.href = "/admin/warehouseIn/confirm";
                });
                console.log(res);
            } catch (e) {
                this.errors = e.response.data.errors;
                console.error(e.response.data);
                this.loadingSubmit = false;
            }
        }
    },
    components: {
        LoadingTable,
        StislaCreateTemplate,
        ModelListSelect
    }
};
</script>
