<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12">
                <div class="card-header">
                    <h4 class="text-danger">Sales Order Details</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <!-- Sales Order No -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>Sales Order No</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-bind:class="{'is-invalid': errors.sales_order_id}"
                                        :list="sales_orders"
                                        v-model="sales_order_id"
                                        v-on:input="getDataCustomer()"
                                        option-value="id"
                                        option-text="sales_order_no"
                                        placeholder="Select Sales Order No"
                                    ></model-list-select>
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.sales_order_id"
                                    >
                                        <p>{{ errors.sales_order_id[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Driver -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>Driver</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        v-bind:class="{'is-invalid': errors.driver_id}"
                                        :list="drivers"
                                        v-model="driver_id"
                                        option-value="id"
                                        option-text="name"
                                        placeholder="Select Driver"
                                    ></model-list-select>
                                    <div
                                        style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                        v-if="errors.driver_id"
                                    >
                                        <p>{{ errors.driver_id[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Customer -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>Customer</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <input type="text" class="form-control" v-model="customer_name" disabled/>
                                </div>
                            </div>
                        </div>
                        <!-- DO Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>DO Date</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <date-picker
                                        v-model="do_date"
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

                        <div v-if="sales_order_id != ''" class="col-12">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table class="table table-hover" id="contentTable" style="font-size: 9pt;">
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
                                    <tr v-for="(orders, index) in sales_order_details" v-bind:key="index">
                                        <td>{{ orders.skuid }}</td>
                                        <td>{{ orders.item_name }}</td>
                                        <td>{{ orders.qty }}</td>
                                        <td>{{ orders.uom_name }}</td>
                                        <td>
                                            <input v-model="qty_do[index].qty" v-on:change="validateQtyDO(index)"
                                                   type="number" class="form-control" :max="orders.qty"/>
                                        </td>
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
                                <textarea v-model="remark" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card-body">
                                <button class="btn btn-danger" v-on:click="submitForm()">Submit</button>
                                <button type="button" class="btn btn-secondary" onclick="back()">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {ModelListSelect} from "vue-search-select";

    export default {
        props: ["user_id"],
        data() {
            return {
                sales_order_id: "",
                customer_id: "",
                customer_name: "",
                do_date: "",
                driver_id: "",
                remark: "",
                sales_order: {},
                sales_orders: [],
                sales_order_details: [],
                drivers: [],
                qty_do: [],
                errors: []
            };
        },
        mounted() {
            this.getData();
        },
        methods: {
            validateQtyDO(idx) {
                let qty_do = parseFloat(this.qty_do[idx].qty);
                let qty_so = parseFloat(this.sales_order_details[idx].qty) + (this.sales_order_details[idx].qty * 0.1);
                console.log(qty_so);
                if (qty_do > qty_so) {
                    this.qty_do[idx].qty = qty_so;
                }
            },
            getDataCustomer() {
                axios
                    .get(
                        this.$parent.MakeUrl(
                            "api/marketing/sales_order/" + this.sales_order_id
                        )
                    )
                    .then(res => {
                        this.sales_order = res.data.data;
                        this.sales_order_details = this.sales_order.sales_order_details;
                        this.customer_name = this.sales_order.customer_name;
                        this.customer_id = this.sales_order.customer_id;
                        this.qty_do = this.sales_order_details.map((item, idx) => ({
                            qty: item.qty
                        }));
                    })
                    .catch(err => {
                    });
            },
            async submitForm() {
                const payload = {
                    user_id: this.user_id,
                    sales_order_id: this.sales_order_id,
                    customer_id: this.customer_id,
                    do_date: this.do_date,
                    driver_id: this.driver_id,
                    remark: this.remark,
                    so_details: this.sales_order_details.map((item, idx) => ({
                        id: item.id,
                        skuid: item.skuid,
                        uom_id: item.uom_id,
                        qty_do: this.qty_do[idx].qty
                    }))
                };
                try {
                    const res = await axios.post("/api/warehouse/delivery_order", payload);
                    Vue.swal({
                        type: "success",
                        title: "Success!",
                        text: "Successfully Insert Data!"
                    });
                    // setTimeout(function() {
                    //   window.location.href = "/admin/warehouse/delivery_order";
                    // }, 2500);
                    console.log("RES SALES ORDER", res);
                } catch (e) {
                    this.errors = e.response.data.errors;
                    console.error(e.response.data);
                }
            },
            getData() {
                axios
                    .all([
                        axios.get(this.$parent.MakeUrl("api/marketing/sales_order")),
                        axios.get(this.$parent.MakeUrl("api/master_data/driver"))
                    ])
                    .then(
                        axios.spread((sales_order, driver) => {
                            this.sales_orders = sales_order.data;
                            this.drivers = driver.data;
                        })
                    )
                    .catch(err => {
                    });
            }
        },
        components: {
            ModelListSelect
        }
    };
</script>

