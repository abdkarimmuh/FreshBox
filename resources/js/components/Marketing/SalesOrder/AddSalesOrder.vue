<template>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-primary" v-if="message">
                {{ message }}
            </div>
            <div class="card col-12">
                <div class="card-header">
                    <h4>Sales Order Details</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Sales Order No</b><span style="color: red;">*</span></label>
                                <div>
                                    <input v-bind:class="{'is-invalid': errors.email}" type="text"
                                           v-model="sales_order_no"
                                           class="form-control" placeholder="Sales Order No.">
                                    <div class="invalid-feedback" v-if="errors.email">
                                        <p>{{ errors.email[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Customer</b><span style="color: red;">*</span></label>
                                <div>
                                    <model-list-select :list="customers"
                                                       v-model="customer_id"
                                                       v-on:input="getData()"
                                                       option-value="id"
                                                       option-text="name"
                                                       placeholder="Select Customer">
                                    </model-list-select>
                                    <div class="invalid-feedback" v-if="errors.customers">
                                        <p>{{ errors.customers[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Source Order</b><span style="color: red;">*</span></label>
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Fulfillment Date</b><span style="color: red;">*</span></label>
                                <div>
                                    <date-picker v-model="fulfillment_date" lang="en" valueType="format"
                                                 :not-before="new Date()"></date-picker>

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
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">UOM</th>
                                        <th class="text-center">Amount Price</th>
                                        <th class="text-center">Total Amount</th>
                                        <th class="text-center">Notes</th>
                                        <!--                                        <th></th>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(orders, index) in orders_detail" :key="orders.id">
                                        <td>{{ orders.skuid }}</td>
                                        <td>{{ orders.item_name }}</td>
                                        <td style="text-align: right;">
                                            <input v-model="qty[index]" type="number" placeholder="Qty" min="0"
                                                   oninput="validity.valid||(value='');"
                                                   class="form-control qty">
                                        </td>
                                        <td>{{ orders.uom }}</td>
                                        <td style="text-align: right;">
                                            {{ formatPrice(orders.amount) }}
                                        </td>
                                        <td style="text-align: right">{{ formatPrice(total_amount[index])}}</td>
                                        <td>
                                            <input v-model="notes[index]" type="text" placeholder="Notes"
                                                   class="form-control">
                                        </td>
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Remarks</b></label>
                                <textarea v-model="remark" class="form-control" id="Remarks" name="Remarks"></textarea>
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
</template>

<script>
    import {ModelListSelect} from 'vue-search-select';

    export default {
        data() {
            return {
                qty: [
                    0
                ],
                notes: [],
                remark: '',
                total_amount: [],
                source_order_id: 1,
                source_orders: [],
                fulfillment_date: '',
                sales_order_no: '',
                message: '',
                errors: [],
                customer_id: '0',
                customers: [],
                orders_detail: [],
                loading: false,
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            formatPrice(value) {
                return value.toLocaleString('id-ID', {
                    minimumFractionDigits: 2
                });
            },
            getData() {
                axios.all([
                    axios.get(this.$parent.MakeUrl('api/master_data/customer/list')),
                    axios.get(this.$parent.MakeUrl('api/master_data/price/customer/' + this.customer_id)),
                    axios.get(this.$parent.MakeUrl('api/master_data/source_order/list')),
                ]).then(axios.spread((customers, orders_detail, source_order) => {
                    this.customers = customers.data;
                    this.orders_detail = orders_detail.data.data;
                    this.source_orders = source_order.data;
                    this.qty = [
                        0
                    ];
                    this.total_amount = [];
                    this.notes = [];
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
                    details: this.orders_detail.map((item, idx) => ({
                        skuid: item.skuid,
                        qty: this.qty[idx],
                        notes: this.notes[idx]
                    }))
                };
                try {
                    const res = await axios.post('/api/marketing/sales_order_detail', payload);
                    Vue.swal({
                        type: 'success',
                        title: 'Success!',
                        text: 'Successfully Insert Data!'
                    });
                    setTimeout(function () {
                        window.location.href = '/admin/marketing/form_sales_order';
                    }, 3000);

                    console.log('RES SALES ORDER', res)
                } catch (e) {
                    console.error(e)
                }
            }
        },
        components: {
            ModelListSelect
        },
        computed: {
            totalItem: function () {
                let sum = 0;
                this.total_amount.forEach(function (item) {
                    sum += (parseFloat(item));
                });

                return sum.toLocaleString('id-ID', {
                    minimumFractionDigits: 2
                });
            },
        },
        watch: {
            qty: function (newQty, oldQty) {
                this.total_amount = this.orders_detail.map((item, idx) => item.amount * (newQty[idx] || 0))
            }
        }
    }

</script>

