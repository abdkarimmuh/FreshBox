<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12" v-if="!loading">
                <div class="card-header">
                    <h4 class="text-danger">Edit Request Cash Advance</h4>
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
                            <div class="form-group">
                                <label>
                                    <b>Product Type</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-bind:class="{
                                            'is-invalid': errors.productType
                                        }"
                                        :list="productTypes"
                                        v-model="productType"
                                        option-value="value"
                                        option-text="name"
                                        placeholder="Select Product Type"
                                    />
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.productType"
                                    >
                                        <p>{{ errors.productType[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Alamat Kirim-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <b>Warehouse Address</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div style="margin-top: .15rem;">
                                    <model-list-select
                                        v-bind:class="{
                                            'is-invalid': errors.address
                                        }"
                                        :list="warehouses"
                                        v-model="warehouseId"
                                        option-value="id"
                                        option-text="name"
                                        placeholder="Select Warehouse"
                                    />
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.warehouse"
                                    >
                                        <p>{{ errors.warehouse[0] }}</p>
                                    </div>
                                </div>
                            </div>
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
                            title="Bank Name"
                            :model="user.bank_name"
                            disabled="true"
                        />

                        <s-form-input
                            col="3"
                            title="Bank Account"
                            :model="user.bank_account"
                            disabled="true"
                        />
                        <!--Button Add Rows-->
                        <div class="col-md-12" v-if="productType === 1">
                            <div class="form-group text-right">
                                <button
                                    class="btn btn-primary"
                                    @click="pushRows()"
                                >
                                    Add Row
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6" v-if="productType === 2">
                            <div class="form-group">
                                <label>
                                    <b>Items</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <model-list-select
                                    :list="items"
                                    v-model="itemId"
                                    v-on:input="getDetailItem"
                                    option-value="id"
                                    option-text="name_item"
                                    placeholder="Select Item"
                                ></model-list-select>
                            </div>
                        </div>
                        <!--Button Add Items-->
                        <div class="col-md-6 mt-4" v-if="productType == 2">
                            <div class="form-group">
                                <button
                                    class="btn btn-sm btn-primary"
                                    @click="pushItems(itemId)"
                                >
                                    Add Items
                                </button>
                            </div>
                        </div>

                        <div class="col-12" v-if="productType !== ''">
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
                                            <th class="text-center">Uom</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">PPN(%)</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">
                                                Suplier Name
                                            </th>
                                            <th class="text-center">
                                                Remark
                                            </th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(item, index) in detail"
                                            v-bind:key="index"
                                            v-if="productType === 1"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td>
                                                <input
                                                    v-model="item.item_name"
                                                    type="text"
                                                    class="form-control"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    v-model="item.skuid"
                                                    type="text"
                                                    class="form-control"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    v-model="item.qty"
                                                    type="number"
                                                    class="form-control"
                                                    min="0"
                                                />
                                            </td>
                                            <td>
                                                <model-list-select
                                                    :list="uom"
                                                    v-model="item.uom_id"
                                                    option-value="id"
                                                    option-text="name"
                                                    placeholder="Select"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    v-model="item.price"
                                                    type="number"
                                                    class="form-control"
                                                    @change="updateTotalAmount"
                                                    min="0"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    v-model="item.ppn"
                                                    type="number"
                                                    class="form-control"
                                                    @change="updateTotalAmount"
                                                    min="0"
                                                />
                                            </td>
                                            <td>{{ item.total }}</td>
                                            <td>
                                                <model-list-select
                                                    :list="suppliers"
                                                    v-model="item.supplier_id"
                                                    option-value="id"
                                                    option-text="name"
                                                    placeholder="Select"
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
                                                <button
                                                    class="btn btn-icon btn-sm btn-danger"
                                                    @click="deleteRow(index)"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr
                                            v-for="(item, index) in detail"
                                            v-bind:key="index"
                                            v-if="productType === 2"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ item.item_name }}</td>
                                            <td>{{ item.skuid }}</td>
                                            <td>
                                                <input
                                                    v-model="item.qty"
                                                    type="number"
                                                    class="form-control"
                                                    min="0"
                                                />
                                            </td>
                                            <td>
                                                <model-list-select
                                                    :list="uom"
                                                    v-model="item.uom_id"
                                                    option-value="id"
                                                    option-text="name"
                                                    placeholder="Select"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    v-model="item.price"
                                                    type="number"
                                                    class="form-control"
                                                    @change="updateTotalAmount"
                                                    min="0"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    v-model="item.ppn"
                                                    type="number"
                                                    class="form-control"
                                                    @change="updateTotalAmount"
                                                    min="0"
                                                />
                                            </td>
                                            <td>{{ item.total }}</td>
                                            <td>
                                                <model-list-select
                                                    :list="suppliers"
                                                    v-model="item.supplier_id"
                                                    option-value="id"
                                                    option-text="name"
                                                    placeholder="Select"
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
                                                <button
                                                    class="btn btn-icon btn-sm btn-danger"
                                                    @click="deleteRow(index)"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
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
            requestTypes: [
                {
                    name: "Cash",
                    value: 1
                },
                {
                    name: "Advance",
                    value: 2
                }
            ],
            requestType: "",
            uom: [],
            productTypes: [
                {
                    name: "Non Core",
                    value: 1
                },
                {
                    name: "Core",
                    value: 2
                }
            ],
            productType: "",
            warehouses: [],
            warehouseId: "",
            requestDate: "",
            users: [],
            suppliers: [],
            userId: "",
            user: {},
            items: [],
            itemId: "",
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
                userId: this.userId,
                warehouse: this.warehouseId,
                requestDate: this.requestDate,
                productType: this.productType,
                requestType: this.requestType,
                detail: this.detail.map((item, idx) => ({
                    item_name: item.item_name,
                    skuid: item.skuid,
                    uom_id: item.uom_id,
                    qty: item.qty,
                    ppn: item.ppn,
                    price: item.price,
                    total: item.total,
                    qty_confirm: 0,
                    price_confirm: 0,
                    total_confirm: 0,
                    supplier_id: item.supplier_id,
                    remarks: item.remarks
                }))
            };
            console.log(payload);
            try {
                const res = await axios.post(
                    "/api/v1/finance-ap/request-advance/update",
                    payload
                );
                Vue.swal({
                    type: "success",
                    title: "Success!",
                    text: "Successfully Insert Data!"
                }).then(next => {
                    this.$router.push({ name: "finance.requestAdvance" });
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
                        this.$parent.MakeUrl("api/v1/master_data/vendor")
                    ),
                    axios.get(
                        this.$parent.MakeUrl("api/v1/master_data/vendor/pure")
                    ),
                    axios.get(
                        this.$parent.MakeUrl(
                            "api/v1/finance-ap/request-advance/show/" +
                                this.$route.params.id
                        )
                    ),
                    // axios.get(
                    //     this.$parent.MakeUrl(
                    //         "api/v1/finance-ap/request-advance/requestFinanceDetail/" +
                    //             this.$route.params.id
                    //     )
                    // ),
                    axios.get(this.$parent.MakeUrl("api/v1/master_data/items")),
                    axios.get(
                        this.$parent.MakeUrl("api/v1/master_data/warehouse")
                    ),
                    axios.get(this.$parent.MakeUrl("api/v1/master_data/uom"))
                ])
                .then(
                    axios.spread(
                        (
                            users,
                            supplier,
                            requestAdvance,
                            // detail,
                            items,
                            warehouses,
                            uom
                        ) => {
                            this.users = users.data.data;
                            this.suppliers = supplier.data.data;
                            this.requestAdvance = requestAdvance.data.data;
                            this.detail = requestAdvance.data.data.details;
                            this.productType =
                                requestAdvance.data.data.product_type;
                            this.warehouseId =
                                requestAdvance.data.data.master_warehouse_id;
                            this.items = items.data;
                            this.warehouses = warehouses.data;
                            this.uom = uom.data.data;
                            this.loading = false;
                            this.getUser(this.requestAdvance.user_id);
                            console.log(requestAdvance);
                        }
                    )
                )
                .catch(err => {
                    console.error(err)
                    if (err.response.status === 500) {
                        this.getData();
                    }
                });
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
                    console.log("res get detail : ", res)
                })
                .catch(err => {
                    console.log(err.response.data);
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
        pushItems(id) {
            console.log(this.detail);
            if (!id) return;
            const indexItem = this.detail.findIndex(x => x.id === id);
            if (indexItem >= 0) {
                Vue.swal({
                    type: "error",
                    title: "ERROR!",
                    text: "Item Already Added!"
                });
                console.log("GAGAL");
            } else {
                return this.detail.push({
                    id: this.item.id,
                    item_name: this.item.name_item,
                    skuid: this.item.skuid,
                    uom_id: 0,
                    qty: 0,
                    ppn: 0,
                    price: 0,
                    total: 0,
                    qty_confirm: 0,
                    price_confirm: 0,
                    total_confirm: 0,
                    supplier_id: "",
                    remarks: ""
                });
            }
        },
        pushRows() {
            return this.detail.push({
                item_name: "",
                skuid: "",
                uom_id: 0,
                qty: 0,
                ppn: 0,
                price: 0,
                total: 0,
                qty_confirm: 0,
                price_confirm: 0,
                total_confirm: 0,
                supplier_id: "",
                remarks: ""
            });
        },
        clearOrderDetails() {
            this.detail = [];
        },
        deleteRow(index) {
            this.detail.splice(index, 1);
        },
        updateTotalAmount() {
            this.detail.map(
                (item, idx) =>
                    (item.total =
                        parseInt(item.price) +
                        (parseInt(item.price) * parseInt(item.ppn)) / 100)
            );
        }
    },
    components: {
        ModelListSelect
    }
};
</script>
