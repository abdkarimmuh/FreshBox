<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12" v-if="!loading">
                <div class="card-header">
                    <h4 class="text-danger">Confirm Request Cash Finance</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <!-- Confirm Date -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>
                                    <b>Confirm Date</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <date-picker
                                        v-model="confirmDate"
                                        lang="en"
                                        type="date"
                                        valueType="format"
                                        :not-before="new Date()"
                                        format="YYYY-MM-DD"
                                    />
                                </div>
                                <div
                                    style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                    v-if="errors.confirmDate"
                                >
                                    <p>{{ errors.confirmDate[0] }}</p>
                                </div>
                            </div>
                        </div>
                        <s-form-input
                            col="2"
                            title="No Request"
                            :model="requestFinance.no_request"
                            disabled="true"
                        />
                        <s-form-input
                            col="2"
                            title="Request Date"
                            :model="requestFinance.request_date"
                            disabled="true"
                        />

                        <s-form-input
                            col="2"
                            title="Dept"
                            :model="requestFinance.dept"
                            disabled="true"
                        />
                        <s-form-input
                            col="2"
                            title="Nama Rekening"
                            :model="requestFinance.namaRek"
                            disabled="true"
                        />
                        <s-form-input
                            col="2"
                            title="Nomor Rekening"
                            :model="requestFinance.noRek"
                            disabled="true"
                        />

                        <s-form-input
                            col="2"
                            title="Alamat Kirim"
                            :model="requestFinance.shipping_address"
                            disabled="true"
                        />
                        <s-form-input
                            col="2"
                            title="Nominal Permintaan"
                            :model="requestFinance.total | toIDR"
                            disabled="true"
                        />
                        <!--Button Add Rows-->
                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table
                            class="table table-hover"
                            style="font-size: 9pt;"
                        >
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Jenis Barang</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center" colspan="2">
                                        Harga + PPN
                                    </th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Qty Confirm</th>
                                    <th class="text-center">Price Confirm</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center">Checkbox</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(item, index) in orderDetails"
                                    v-bind:key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.itemName }}</td>
                                    <td>{{ item.typeOfGoods }}</td>
                                    <td>{{ item.qty }}</td>
                                    <td>{{ item.uom_name }}</td>
                                    <td>{{ item.price }}</td>
                                    <td>{{ item.ppn }}</td>
                                    <td>{{ item.total }}</td>
                                    <td>
                                        <input
                                            v-model="item.qty_confirm"
                                            type="number"
                                            class="form-control"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            v-model="item.price_confirm"
                                            type="number"
                                            class="form-control"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            v-model="item.remarks"
                                            type="text"
                                            class="form-control"
                                        />
                                    </td>
                                    <td>
                                        <div
                                            class="custom-checkbox custom-control"
                                        >
                                            <input
                                                type="checkbox"
                                                class="custom-control-input"
                                                value="1"
                                                v-model="item.checked"
                                                :id="'checkbox-' + index"
                                            />
                                            <label
                                                :for="'checkbox-' + index"
                                                class="custom-control-label"
                                                >&nbsp;</label
                                            >
                                        </div>
                                    </td>
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
            confirmDate: "",
            requestFinance: "",
            orderDetails: [],
            errors: [],
            loading: true,
            loadingSubmit: false
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        async submitForm() {
            this.loadingSubmit = true;
            const payload = {
                confirmDate: this.confirmDate,
                orderDetails: this.orderDetails.map((item, idx) => ({
                    id: item.id,
                    qtyConfirm: item.qty_confirm,
                    priceConfirm: item.price_confirm,
                    checked: item.checked,
                    remarks: item.remarks
                }))
            };
            try {
                const res = await axios.patch(
                    "/api/v1/finance-ap/request-finance",
                    payload
                );
                Vue.swal({
                    type: "success",
                    title: "Success!",
                    text: "Successfully Insert Data!"
                }).then(next => {
                    this.$router.push({ name: "finance.requestFinance" });
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
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/finance-ap/request-finance/show/" +
                            this.$route.params.id
                    )
                )
                .then(res => {
                    this.requestFinance = res.data.data;
                    this.orderDetails = res.data.data.details;
                    this.loading = false;
                })
                .catch(e => {});
        },
        getDetailItem() {
            this.loading = true;
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/master_data/items/" + this.itemId
                    )
                )
                .then(res => {
                    this.item = res.data;
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        getUser() {
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/master_data/users/" + this.userId
                    )
                )
                .then(res => {
                    this.user = res.data.data;
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        pushItems(id) {
            if (!id) return;
            const indexItem = this.orderDetails.findIndex(x => x.id === id);
            if (indexItem >= 0) {
                Vue.swal({
                    type: "error",
                    title: "ERROR!",
                    text: "Item Already Added!"
                });
                console.log("GAGAL");
            } else {
                return this.orderDetails.push({
                    id: this.item.id,
                    name: this.item.name_item,
                    skuid: this.item.skuid,
                    uom_id: 0,
                    qty: 0,
                    ppn: 0,
                    price: 0,
                    total: 0,
                    supplierName: "",
                    remark: ""
                });
            }
        },
        pushRows() {
            return this.orderDetails.push({
                name: "",
                skuid: "",
                uom_id: 0,
                qty: 0,
                ppn: 0,
                price: 0,
                total: 0,
                supplierName: "",
                remark: ""
            });
        }
    },
    components: {
        ModelListSelect
    }
};
</script>
