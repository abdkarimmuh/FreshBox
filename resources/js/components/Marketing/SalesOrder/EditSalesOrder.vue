<template>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-primary" v-if="message">
                {{ message }}
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Sales Order Details</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Sales Order No<span style="color: red;">*</span></label>
                                <div>
                                    <input v-bind:class="{'is-invalid': errors.sales_order_no}" type="text"
                                           v-model="sales_order_no"
                                           class="form-control" placeholder="Sales Order No.">
                                    <div class="invalid-feedback" v-if="errors.sales_order_no">
                                        <p>{{ errors.sales_order_no[0] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Customer<span style="color: red;">*</span></label>
                                <div>
                                    <model-list-select :list="customers"
                                                       v-model="customer_id"
                                                       v-on:input="getData()"
                                                       option-value="id"
                                                       option-text="customer_name"
                                                       placeholder="Select Customer">
                                    </model-list-select>
                                    <div class="invalid-feedback" v-if="errors.customers">
                                        <p>{{ errors.customers[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Source Order</label>
                                <div>
                                    <model-list-select :list="source_orders"
                                                       v-model="source_order_id"
                                                       option-value="id"
                                                       option-text="name"
                                                       placeholder="Select Source Order">
                                    </model-list-select>
                                    <div class="invalid-feedback" v-if="errors.source_order">
                                        <p>{{ errors.source_order[0] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Fulfillment Date</label>
                                <div>
                                    <date-picker v-model="fulfillment_date" lang="en" valueType="format"></date-picker>
                                    <div class="invalid-feedback" v-if="errors.fulfillment_date">
                                        <p>{{ errors.fulfillment_date[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="customer_id != 0" class="col-12">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table class="table table-hover" id="contentTable" style="font-size: 9pt;">
                                    <thead>
                                    <tr>
                                        <th class="text-center">SKUID</th>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center">UOM</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Amount Price</th>
                                        <th class="text-center">Total Amount</th>
                                        <th class="text-center">Notes</th>
                                        <!--                                        <th></th>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(orders, index) in sales_order_details"
                                        :key="orders.id">
                                        <td>{{ orders.skuid }}</td>
                                        <td>{{ orders.item_name }}</td>
                                        <td>{{ orders.uom }}</td>
                                        <td style="text-align: right;">
                                            <input v-model="sales_order_details[index]['qty']" type="number"
                                                   placeholder="Qty"
                                                   class="form-control">
                                        </td>
                                        <td style="text-align: right;">{{ orders.amount_price }}</td>
                                        <td style="text-align: right">{{total_amount[index] }}</td>
                                        <td>
                                            <input v-model="sales_order_details[index]['notes']" type="text"
                                                   placeholder="Notes"
                                                   class="form-control">
                                        </td>
                                        <!--                                        <td><a href="#" id="delete|sod|94" role="button" title="Delete"-->
                                        <!--                                               onclick="deleteSalesOrderDetail(94,);"><span-->
                                        <!--                                            class="badge badge-pill badge-danger">Delete</span></a></td>-->
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align: right;">Grand Total</td>
                                        <td style="text-align: right;">{{ totalItem }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea v-model="remark" class="form-control" id="Remarks"
                                              name="Remarks"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-body">
                                    <button class="btn btn-primary" v-on:click="submitForm()">Submit</button>
                                    <button type="button" class="btn btn-secondary" onclick="back()">Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {ModelListSelect} from 'vue-search-select';

    export default {
        data() {
            return {
                sales_order_no: '',
                source_order_id: '',
                sales_order: {},
                sales_order_details: [],
                customer_id: '',
                fulfillment_date: '',
                total_amount: [],
                remark: '',
                customers: [],
                orders_detail: [],
                source_orders: [],
                errors: [],
                qty: [],
                notes: [],
                message: '',
                loading: false
            }
        },
        mounted() {
            this.getData();
            console.log(this.sales_order);
        },
        methods: {
            getData() {
                axios.all([
                    axios.get(this.$parent.MakeUrl('api/master_data/customer/list')),
                    axios.get(this.$parent.MakeUrl('api/marketing/sales_order/' + this.$route.params.id)),
                    axios.get(this.$parent.MakeUrl('api/master_data/price/customer/1')),
                    axios.get(this.$parent.MakeUrl('api/master_data/source_order/list'))

                ]).then(axios.spread((customers, sales_order, orders_detail, source_order) => {
                    this.customers = customers.data;

                    this.sales_order = sales_order.data;
                    this.sales_order_no = sales_order.data.sales_order_no;
                    this.customer_id = sales_order.data.customer_id;
                    this.source_order_id = sales_order.data.source_order_id;
                    this.fulfillment_date = sales_order.data.fulfillment_date;
                    this.remark = sales_order.data.remarks;

                    this.orders_detail = orders_detail.data.data;
                    this.source_orders = source_order.data;

                    this.sales_order_details = sales_order.data.sales_order_details
                })).catch((err) => {
                    if (err.response.status == 403) {
                        this.$router.push({name: 'form_sales_order'})
                    }
                })
            },
            async submitForm() {
                const payload = {
                    customerId: this.customer_id,
                    remark: this.remark,
                    fulfillmentDate: this.fulfillment_date,
                    salesOrderNo: this.sales_order_no,
                    sourceOrderId: this.source_order_id,
                    details_id: this.sales_order_details.map((item, idx) => ({
                        id: item.id
                    })),
                    details: this.sales_order_details.map((item, idx) => ({
                        skuid: item.skuid,
                        qty: this.qty[idx],
                        notes: this.notes[idx]
                    }))
                };
                try {
                    const res = await axios.post('/api/sales_order_detail', payload);
                    console.log('RES SALES ORDER', res)
                } catch (e) {
                    console.error(e)
                }
            }
        },
        components: {
            ModelListSelect
        }
        ,
        computed: {
            totalItem: function () {
                let sum = 0;
                this.total_amount.forEach(function (item) {
                    sum += (parseFloat(item));
                });

                return sum.toLocaleString('id-ID', {
                    currency: 'IDR',
                    style: 'currency'
                });
            },
        },
        watch: {
            qty: function (newQty, oldQty) {
                this.total_amount = this.sales_order_details.map((item, idx) => item.amount_price * (newQty[idx] || 0))
            }
        }
    }
</script>
