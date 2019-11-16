<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12">
                <div class="card-header">
                    <h4 class="text-danger">Confirm Delivery Order</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <!-- Confirm Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>Confirm Date</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <date-picker
                                        v-model="confirm_date"
                                        lang="en"
                                        valueType="format">
                                        >
                                    </date-picker>
                                </div>
                                <div
                                    style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                    v-if="errors.confirm_date"
                                >
                                    <p>{{ errors.confirm_date[0] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">

                    <div class="row" v-for="(item,idx) in delivery_order">
                        <s-form-input
                            :model="item.delivery_order_no"
                            col="6"
                            title="Delivery Order No"
                            type="text"
                            :disabled="true"
                        ></s-form-input>
                        <div class="col-12">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table class="table table-hover" style="font-size: 9pt;">
                                    <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">SKUID</th>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center">UOM</th>
                                        <th class="text-center">Qty Order</th>
                                        <th class="text-center">Qty Do</th>
                                        <th class="text-center">Qty Confirm</th>
                                        <th class="text-center">Qty Minus</th>
                                        <th class="text-center">Remark Confirm</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(order, index) in item.do_details" v-bind:key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ order.skuid }}</td>
                                        <td>{{ order.item_name }}</td>
                                        <td>{{ order.uom_name }}</td>
                                        <td>{{ order.qty_order }}</td>
                                        <td>{{ order.qty_do }}</td>
                                        <td>
                                            <input
                                                v-model="order.qty_confirm"
                                                type="number"
                                                class="form-control"
                                                :max="order.qty"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="order.qty_minus"
                                                type="number"
                                                min="0"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="order.remark"
                                                type="text"
                                                class="form-control"
                                                placeholder="Remark Confirm"
                                            />
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
                                <textarea
                                    v-model="delivery_order.remark"
                                    class="form-control"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card-body">
                            <button
                                class="btn btn-danger"
                                v-on:click="submitForm()"
                            >Submit
                            </button>
                            <button
                                type="button"
                                class="btn btn-secondary"
                                onclick="back()"
                            >Back
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                confirm_date: "",
                delivery_order: [],
                do_details: [],
                qty_minus: [],
                errors: []
            };
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                const payload = {
                    id: this.$route.query.id,
                };
                axios.get(this.$parent.MakeUrl("api/v1/warehouse/confirm_deliver_order/show"), {params: payload})
                    .then(res => {
                        console.log(res);
                        this.delivery_order = res.data.data;
                        this.do_details = res.data.data.do_details;
                        this.delivery_order = res.data.data.map((item, idx) => ({
                            do_details: item.do_details((details,idx) => ({
                                qty_confirm: details.qty_do,
                                qty_minus:  details.qty_do,
                            }))
                        }));

                    })
                    .catch(err => {
                    });
            },
            async submitForm() {
                const payload = {
                    delivery_order: this.delivery_order.map((item, idx) => ({
                        id: item.delivery_order.id,
                        sales_order_id: item.delivery_order.sales_order_id,
                        confirm_date: item.confirm_date,
                        do_details: item.do_details.map((detail, idx) => ({
                            id: detail.id,
                            remark: detail.remark,
                            qty_confirm: detail.qty_confirm[idx].qty,
                            qty_minus: detail.qty_minus[idx].qty
                        }))
                    }))
                };
                try {
                    const res = await axios.patch(this.$parent.MakeUrl("admin/warehouse/confirm_delivery_order/update"), payload);
                    Vue.swal({
                        type: "success",
                        title: "Success!",
                        text: "Successfully Confirm Delivery Order!"
                    }).then(next => {
                        window.location.href = "/admin/warehouse/confirm_delivery_order";
                    });
                    console.log(res);
                } catch (e) {
                    this.errors = e.response.data.errors;
                    console.error(e.response.data);
                }
            },

        }
    };
</script>

