<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12" v-if="!loading">
                <div class="card-header">
                    <h4 class="text-danger">Add Request Advance</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <!-- User -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>User</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-bind:class="{'is-invalid': errors.sales_order_id}"
                                        :list="Users"
                                        v-model="delivery_order.sales_order_id"
                                        v-on:input="getDataCustomer()"
                                        option-value="value"
                                        option-text="name"
                                        placeholder="Select Sales Order No"
                                    ></model-list-select>
                                    <div style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                         v-if="errors.sales_order_id">
                                        <p>{{ errors.sales_order_id[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Driver -->
                        <div class="col-md-3">
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
                                    ></model-list-select>
                                    <div style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                         v-if="errors.requestType">
                                        <p>{{ errors.requestType[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Product Types-->
                        <div class="col-md-3" v-if="requestType === 2">
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
                                    ></model-list-select>
                                    <div style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                         v-if="errors.productType">
                                        <p>{{ errors.productType[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-if="productType === 1" class="col-12">
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
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in listItems" v-bind:key="index">
                                        <td> {{ index + 1}}</td>
                                        <td>nama barang</td>
                                        <td> jenis barang</td>
                                        <td></td>
                                        <td>
                                            <input
                                                v-model="item.unit"
                                                type="number"
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
                                        <td>Total</td>
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
                                    </tr>
                                    </tbody>
                                </table>
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
                                    v-model="skuid"
                                    v-on:input="getItem"
                                    option-value="skuid"
                                    option-text="item_name"
                                    placeholder="Select Item">
                                </model-list-select>

                            </div>
                        </div>
                        <div v-if="productType === 2" class="col-12">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table class="table table-hover" style="font-size: 9pt;">
                                    <thead>
                                    <tr>
                                        <th class="text-center">SKUID</th>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">UOM</th>
                                        <th class="text-center">Qty Do</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(orders, index) in listItems" v-bind:key="index">
                                        <td>{{ orders.skuid }}</td>
                                        <td>{{ orders.item_name }}</td>
                                        <td>{{ orders.qty }}</td>
                                        <td>{{ orders.uom_name }}</td>
                                        <td>
                                            <input
                                                v-model="qty_do[index].qty"
                                                v-on:change="validateQtyDO(index)"
                                                type="number"
                                                class="form-control"
                                                :max="orders.qty"
                                            />
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12" v-if="delivery_order.sales_order_id !== ''">
                            <div class="form-group">
                                <label>
                                    <b>Remark</b>
                                </label>
                                <textarea v-model="delivery_order.remark" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card-body">
                                <div v-if="loadingSubmit">
                                    <loading-button/>
                                </div>
                                <div v-else>
                                    <button class="btn btn-danger" v-on:click="submitForm()"
                                            v-if="delivery_order.sales_order_id !== ''">
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
                Users: [
                    {
                        name: 'Non Core',
                        value: 1
                    },
                    {
                        name: 'Core',
                        value: 2
                    }
                ],
                user: '',
                listItems: [],
                delivery_order: {
                    sales_order_id: "",
                    customer_id: "",
                    customer_name: "",
                    do_date: "",
                    driver_id: "",
                    pic_qc_id: "",
                    remark: "",
                    user_id: UserID
                },
                drivers: [],
                pic_qc: [],
                qty_do: [],
                errors: [],
                loading: false,
                loadingSubmit: false
            };
        },
        mounted() {
            this.getData();
        },
        methods: {
            getDataCustomer() {
                this.loading = true;
                axios.get(this.$parent.MakeUrl("api/v1/marketing/sales_order/show?id=" + this.delivery_order.sales_order_id))
                    .then(res => {
                        this.sales_order = res.data;
                        this.sales_order_details = res.data.sales_order_details;
                        this.delivery_order.customer_name = this.sales_order.customer_name;
                        this.delivery_order.customer_id = this.sales_order.customer_id;
                        this.qty_do = this.sales_order_details.map((item, idx) => ({
                            qty: item.qty
                        }));
                        this.delivery_order.driver_id = res.data.driver_id;
                        this.loading = false;
                    })
                    .catch(err => {
                    });
            },
            async submitForm() {
                this.loadingSubmit = true;
                const payload = {
                    user_id: this.delivery_order.user_id,
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
                        this.$router.push({name: 'delivery_order.index'})
                    });
                    console.log(res);
                } catch (e) {
                    this.loadingSubmit = false;
                    this.errors = e.response.data.errors;
                    console.error(e.response.data);
                }
            },
            getData() {
                // axios.all([
                //     axios.get(this.$parent.MakeUrl("api/v1/warehouse/delivery_order/create")),
                //     axios.get(this.$parent.MakeUrl("api/v1/master_data/driver/driver")),
                //     axios.get(this.$parent.MakeUrl("api/v1/master_data/driver/picqc"))
                // ]).then(
                //     axios.spread((sales_order, driver, pic_qc) => {
                //         this.sales_orders = sales_order.data.data;
                //         this.drivers = driver.data;
                //         this.pic_qc = pic_qc.data;
                //     })
                // ).catch(err => {
                // });
            },
            pushItems() {

            }
        },
        components: {
            ModelListSelect
        }
    };
</script>

