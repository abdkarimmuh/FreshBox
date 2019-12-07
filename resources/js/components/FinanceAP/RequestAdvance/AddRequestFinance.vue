<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12" v-if="!loading">
                <div class="card-header">
                    <h4 class="text-danger">Add Request Finance</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <!-- User -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <b>User</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-bind:class="{'is-invalid': errors.sales_order_id}"
                                        :list="users"
                                        v-model="userId"
                                        v-on:input="getUser()"
                                        option-value="id"
                                        option-text="name"
                                        placeholder="Select User"
                                    />
                                    <div style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                         v-if="errors.sales_order_id">
                                        <p>{{ errors.sales_order_id[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Request Date -->
                        <div class="col-md-2" v-if="userId !== ''">
                            <div class="form-group">
                                <label>
                                    <b>Request Date</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <date-picker
                                        v-model="requestDate"
                                        lang="en"
                                        type="datetime"
                                        valueType="format"
                                        :not-before="new Date()"
                                        format="YYYY-MM-DD HH:mm:ss"
                                    />
                                </div>
                                <div style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                     v-if="errors.fulfillmentDate">
                                    <p>{{ errors.fulfillmentDate[0] }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Request Type -->
                        <div class="col-md-2" v-if="userId !== ''">
                            <div class="form-group">
                                <label>
                                    <b>Request Type</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-bind:class="{'is-invalid': errors.requestType}"
                                        :list="requestTypes"
                                        v-model="requestType"
                                        option-value="value"
                                        option-text="name"
                                        placeholder="Select Request Type"
                                    />
                                    <div style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                         v-if="errors.requestType">
                                        <p>{{ errors.requestType[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Product Types-->
                        <div class="col-md-2" v-if="userId !== ''">
                            <div class="form-group">
                                <label>
                                    <b>Product Type</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-bind:class="{'is-invalid': errors.productType}"
                                        :list="productTypes"
                                        v-model="productType"
                                        option-value="value"
                                        option-text="name"
                                        placeholder="Select Product Type"
                                    />
                                    <div style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                         v-if="errors.productType">
                                        <p>{{ errors.productType[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Alamat Kirim-->
                        <div class="col-md-3" v-if="userId !== ''">
                            <div class="form-group">
                                <label>
                                    <b>Warehouse Address</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-bind:class="{'is-invalid': errors.address}"
                                        :list="addresses"
                                        v-model="address"
                                        option-value="value"
                                        option-text="name"
                                        placeholder="Select Warehouse"
                                    />
                                    <div style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                         v-if="errors.address">
                                        <p>{{ errors.address[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <s-form-input v-if="userId !== ''"
                                      col="3"
                                      title="Name"
                                      :model="user.name"
                                      disabled="true"/>

                        <s-form-input v-if="userId !== ''"
                                      col="3"
                                      title="Dept"
                                      :model="user.dept"
                                      disabled="true"/>

                        <s-form-input v-if="userId !== ''"
                                      col="3"
                                      title="Nama Rekening"
                                      :model="user.nama_rek"
                                      disabled="true"/>

                        <s-form-input v-if="userId !== ''"
                                      col="3"
                                      title="Nomor Rekening"
                                      :model="user.no_rek"
                                      disabled="true"/>

                        <div class="col-md-12" v-if="productType === 1">
                            <div class="form-group text-right">
                                <button class="btn btn-primary" @click="pushRows()">
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
                                    placeholder="Select Item">
                                </model-list-select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4" v-if="productType === 2">
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary" @click="pushItems(itemId)">
                                    Add Items
                                </button>
                            </div>
                        </div>

                        <div class="col-12" v-if="productType !== ''">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table class="table table-hover" style="font-size: 9pt;">
                                    <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Jenis Barang</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center" colspan="2">Harga + PPN</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Nama Suplier</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in orderDetails" v-bind:key="index"
                                        v-if="productType === 1">
                                        <td>{{ index + 1}}</td>
                                        <td>
                                            <input
                                                v-model="item.name"
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
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="item.unit"
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="item.harga"
                                                type="number"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="item.ppn"
                                                type="number"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="item.total"
                                                type="number"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="item.namaSuplier"
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="item.keterangan"
                                                type="number"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <button class="btn btn-icon btn-sm btn-danger"
                                                    @click="deleteRow(index)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-for="(item, index) in orderDetails" v-bind:key="index"
                                        v-if="productType === 2">
                                        <td>{{ index + 1}}</td>
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.skuid }}</td>
                                        <td>
                                            <input
                                                v-model="item.qty"
                                                type="number"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="item.unit"
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="item.harga"
                                                type="number"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="item.ppn"
                                                type="number"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="item.total"
                                                type="number"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="item.namaSuplier"
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="item.keterangan"
                                                type="number"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <button class="btn btn-icon btn-sm btn-danger"
                                                    @click="deleteRow(index)">
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
                                    <loading-button/>
                                </div>
                                <div v-else>
                                    <button class="btn btn-danger" v-on:click="submitForm()"
                                            v-if="userId !== ''">
                                        Submit
                                    </button>
                                    <back-button/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card col-12" v-else>
                <loading-table/>
            </div>
        </div>
    </div>
</template>
<script>
    import {ModelListSelect} from "vue-search-select";

    export default {
        data() {
            return {
                requestTypes: [
                    {
                        name: 'Cash',
                        value: 1
                    },
                    {
                        name: 'Advance',
                        value: 2
                    }
                ],
                requestType: '',
                productTypes: [
                    {
                        name: 'Non Core',
                        value: 1
                    },
                    {
                        name: 'Core',
                        value: 2
                    }
                ],
                productType: '',
                addresses:[
                    {
                        name: 'Office Green Lake',
                        value: 1
                    }
                ],
                address:'',
                requestDate: '',
                users: [],
                userId: '',
                user: '',
                items: [],
                itemId: '',
                orderDetails: [],
                errors: [],
                loading: false,
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
                    productType: this.productType,
                    requestType: this.requestType,
                    userId: this.userId,
                    orderDetails: this.orderDetails.map((item, idx) => ({
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
                        this.$router.push({name: 'delivery_order.index'})
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
                axios.all([
                    axios.get(this.$parent.MakeUrl("api/v1/master_data/users")),
                    axios.get(this.$parent.MakeUrl("api/v1/master_data/items")),
                ]).then(
                    axios.spread((users, items) => {
                        this.users = users.data;
                        this.items = items.data;
                        this.loading = false;
                    })
                ).catch(err => {
                    if (err.response.status === 500) {
                        this.getData()
                    }
                });
            },
            getDetailItem() {
                this.loading = true;
                axios.get(this.$parent.MakeUrl("api/v1/master_data/items/" + this.itemId))
                    .then(res => {
                        this.item = res.data;
                        this.loading = false;
                    })
                    .catch(err => {
                        console.log(err.response.data)
                    });
            },
            getUser() {
                axios.get(this.$parent.MakeUrl("api/v1/master_data/users/" + this.userId))
                    .then(res => {
                        this.user = res.data.data;
                    })
                    .catch(err => {
                        console.log(err.response.data)
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
                        unit: '',
                        qty: 0,
                        ppn: 0,
                        harga: 0,
                        total: 0,
                        namaSuplier: '',
                        keterangan: ''
                    });
                }
            },
            pushRows() {
                return this.orderDetails.push({
                    name: '',
                    skuid: '',
                    unit: '',
                    qty: 0,
                    ppn: 0,
                    harga: 0,
                    total: 0,
                    namaSuplier: '',
                    keterangan: ''
                });
            },
            deleteRow(index) {
                this.orderDetails.splice(index, 1);
            },
        },
        components: {
            ModelListSelect
        }
    };
</script>

