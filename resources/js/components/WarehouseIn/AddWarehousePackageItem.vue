<template>
    <stisla-create-template title="Add Warehouse Package Item">
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
                        <b>Sales Order No</b>
                        <span style="color: red;">*</span>
                    </label>
                    <div>
                        <model-list-select
                            v-bind:class="{ 'is-invalid': errors.soDetailId }"
                            :list="soDetails"
                            v-model="soDetailId"
                            v-on:input="getSODetail()"
                            option-value="id"
                            option-text="no_so"
                            placeholder="Select Sales Order No"
                        ></model-list-select>
                        <div
                            style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                            v-if="errors.soDetailId"
                        >
                            <p>{{ errors.soDetailId[0] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" v-if="soDetailId !== ''">
                <div class="form-group">
                    <label>
                        <b>Vendor Name</b>
                    </label>
                    <div>
                        <input
                            type="text"
                            class="form-control"
                            v-model="soDetail.customer_name"
                            disabled
                        />
                    </div>
                </div>
            </div>
            <div class="col-md-3" v-if="soDetailId !== ''">
                <div class="form-group">
                    <label>
                        <b>QTY</b>
                    </label>
                    <div>
                        <input type="text" class="form-control" v-model="soDetail.qty" disabled />
                    </div>
                </div>
            </div>
            <div class="col-md-3" v-if="soDetailId !== ''">
                <div class="form-group">
                    <label>
                        <b>UOM</b>
                    </label>
                    <div>
                        <input
                            type="text"
                            class="form-control"
                            v-model="soDetail.uom_name"
                            disabled
                        />
                    </div>
                </div>
            </div>
            <div class="col-12" v-if="soDetailId !== ''">
                <div class="card-body">
                    <div v-if="loadingSubmit">
                        <loading-button />
                    </div>
                    <div v-else>
                        <button class="btn btn-danger" v-on:click="submitForm()">Generate Label</button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            onclick="history.back()"
                        >Back</button>
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
            soDetailId: "",
            soDetail: {},
            soDetails: [],
            errors: [],
            loadingSubmit: false,
            loading: false
        };
    },
    mounted() {
        this.getSODetails();
    },
    methods: {
        getSODetails() {
            axios
                .get(this.$parent.MakeUrl("api/v1/marketing/so_detail/isProc"))
                .then(res => {
                    this.soDetails = res.data.data;
                })
                .catch(err => {
                    console.log(err);
                });
        },
        getSODetail() {
            this.loading = true;
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/marketing/so_detail/show/" + this.soDetailId
                    )
                )
                .then(res => {
                    this.soDetail = res.data.data;
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err);
                });
        }
        // async submitForm() {
        //     this.loadingSubmit = true;
        //     const payload = {
        //         soDetailId: this.soDetailId,
        //         userProcId: this.soDetail.user_proc_id,
        //         remark: this.soDetail.remark,
        //         items: this.soDetail.items.map((item, idx) => ({
        //             id: item.id,
        //             bruto: item.bruto,
        //             netto: item.netto,
        //             tara: item.tara,
        //             qty_minus: item.qty_minus
        //         }))
        //     };
        //     try {
        //         const res = await axios.post(
        //             "/api/v1/warehouseIn/confirm/store",
        //             payload
        //         );
        //         Vue.swal({
        //             type: "success",
        //             title: "Success!",
        //             text: "Successfully Insert Data!"
        //         }).then(next => {
        //             window.location.href = "/admin/warehouseIn/confirm";
        //         });
        //     } catch (e) {
        //         this.errors = e.response.data.errors;
        //         console.error(e.response.data);
        //         this.loadingSubmit = false;
        //     }
        // }
    },
    components: {
        LoadingTable,
        StislaCreateTemplate,
        ModelListSelect
    }
};
</script>
