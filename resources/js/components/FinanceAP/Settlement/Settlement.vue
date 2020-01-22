<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12" v-if="!loading">
                <div class="card-header">
                    <h4 class="text-danger">Settlement</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <!-- Request Date -->
                        <div class="col-md-3">
                            <s-form-input
                                title="Request Date"
                                :model="requestAdvance.request_date"
                                disabled="true"
                            />
                        </div>
                        <!-- Request Type -->
                        <div class="col-md-3">
                            <s-form-input
                                title="Request Type"
                                :model="requestAdvance.request_type"
                                disabled="true"
                            />
                        </div>
                        <!--Product Types-->
                        <div class="col-md-3">
                            <s-form-input
                                title="Product Type"
                                :model="requestAdvance.product_type_name"
                                disabled="true"
                            />
                        </div>
                        <!--Alamat Kirim-->
                        <div class="col-md-3">
                            <s-form-input
                                title="Warehouse Address"
                                :model="requestAdvance.shipping_address"
                                disabled="true"
                            />
                        </div>

                        <s-form-input
                            col="3"
                            title="Name"
                            :model="user.name"
                            disabled="true"
                        />

                        <s-form-input
                            col="3"
                            title="Dept"
                            :model="user.dept"
                            disabled="true"
                        />

                        <s-form-input
                            col="3"
                            title="Nama Rekening"
                            :model="user.nama_rek"
                            disabled="true"
                        />

                        <s-form-input
                            col="3"
                            title="Nomor Rekening"
                            :model="user.no_rek"
                            disabled="true"
                        />

                        <div class="col-12" style="margin-top:50px;">
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
                                            <th class="text-center">Qty Confirm</th>
                                            <th class="text-center">Uom</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Price Confirm</th>
                                            <th class="text-center">PPN(%)</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr
                                            v-for="(item, index) in detail"
                                            v-bind:key="index"

                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ item.item_name }}</td>
                                            <td>{{ item.type_of_goods }}</td>
                                            <td>{{ item.qty }}</td>
                                            <td>
                                                <input
                                                    v-model="item.qty_confirm"
                                                    type="number"
                                                    class="form-control"
                                                    min=0
                                                />
                                            </td>
                                            <td>{{ item.uom_name }}</td>
                                            <td>{{ item.price }}</td>
                                            <td>
                                                <input
                                                    v-model="item.price_confirm"
                                                    type="number"
                                                    class="form-control"
                                                    min=0
                                                />
                                            </td>
                                             <td>{{ item.ppn }}</td>

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
            errors: [],
            loading: false,
            loadingSubmit: false,
            requestAdvance: {},
            detail: []
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        async submitForm() {
            this.loadingSubmit = true;
            const payload = {
                id: this.$route.params.id,
                detail: this.detail.map((item, idx) => ({
                    id: item.id,
                    qty_confirm: item.qty_confirm,
                    price_confirm: item.price_confirm,
                }))
            };
            console.log(payload);
            try {
                const res = await axios.post(
                    "/api/v1/finance-ap/request-advance/settlement",
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
                .all([
                    axios.get(
                        this.$parent.MakeUrl(
                            "api/v1/finance-ap/request-advance/show/" +
                                this.$route.params.id
                        )
                    ),
                    axios.get(
                        this.$parent.MakeUrl(
                            "api/v1/finance-ap/request-advance/requestFinanceDetail/" +
                                this.$route.params.id
                        )
                    ),

                ])
                .then(
                    axios.spread(
                        (
                            requestAdvance,
                            detail,
                        ) => {
                            this.requestAdvance = requestAdvance.data.data;
                            this.detail = detail.data.data;
                            this.loading = false;
                            this.getUser(this.requestAdvance.user_id);
                            console.log(detail);
                        }
                    )
                )
                .catch(err => {
                    if (err.response.status === 500) {
                        this.getData();
                    }
                });
        },
        getUser(userId) {
            axios
                .get(this.$parent.MakeUrl("api/v1/master_data/users/getUserVendor/" + userId))
                .then(res => {
                    this.user = res.data.data;
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
    },
    components: {
        ModelListSelect
    }
};
</script>
