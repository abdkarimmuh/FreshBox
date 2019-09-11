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
                                <label><b>Source Order</b><span style="color: red;">*</span></label>
                                <div>
                                    <input type="text" class="form-control" v-model="source_order_name" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" v-if="source_order_id">
                                <label><b>File</b><span style="color: red;">*</span></label>
                                <div>
                                    <a v-bind:href="file_url">{{ file }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" v-if="source_order_id == 1">
                                <label><b>No PO</b><span style="color: red;">*</span></label>
                                <div>
                                    <input type="text" class="form-control" v-model="no_po" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Customer</b><span style="color: red;">*</span></label>
                                <div>
                                    <input type="text" v-model="customer_name" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Fulfillment Date</b><span style="color: red;">*</span></label>
                                <div>
                                    <input type="text" disabled v-model="fulfillment_date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="customer_id != 0">
                            <div class="form-group">
                                <label><b>Items</b><span style="color: red;">*</span></label>
                                <model-list-select :list="items"
                                                   v-model="skuid"
                                                   v-on:input="getItem()"
                                                   option-value="skuid"
                                                   option-text="item_name"
                                                   placeholder="Select Item">
                                </model-list-select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4" v-if="skuid != ''">
                            <div class="form-group">
                                <label></label>
                                <button class="btn btn-sm btn-primary" @click="pushOrderDetails(skuid)">
                                    Add Items
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                 v-if="errors.items">
                                <p>{{ errors.items[0] }}</p>
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
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(orders, index) in orders_detail" v-bind:key="index">
                                        <td>{{ orders.skuid }}</td>
                                        <td>{{ orders.item_name }}</td>
                                        <td>
                                            <input v-model="orders.qty" type="number" placeholder="Qty" min="0"
                                                   oninput="validity.valid||(value='');"
                                                   class="form-control qty" v-on:input="calculateTotalAmount(index)">
                                        </td>
                                        <td>{{ orders.uom_name}}</td>
                                        <td>{{ formatPrice(orders.amount_price) }}</td>
                                        <td>{{ formatPrice(orders.total_amount) }}</td>
                                        <td>
                                            <input v-model="orders.notes"
                                                   type="text"
                                                   placeholder="Notes"
                                                   class="form-control">
                                        </td>
                                        <td>
                                            <button class="btn btn-icon btn-sm btn-danger"
                                                    @click="removeOrderDetails(index)">
                                                <i class="fa fa-trash"></i>
                                            </button>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Remarks</b></label>
                                <textarea v-bind:class="{'is-invalid': errors.remark}" v-model="remark"
                                          class="form-control" id="Remarks" name="Remarks"></textarea>
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
        props: ['sales_order'],
        data() {
            return {
                sales_order_id: this.getSalesOrder('id'),
                source_order_id: this.getSalesOrder('source_order_id'),
                source_order_name: this.getSalesOrder('source_order_name'),
                customer_name: this.getSalesOrder('customer_name'),
                customer_id: this.getSalesOrder('customer_id'),
                fulfillment_date: this.getSalesOrder('fulfillment_date'),
                remark: this.getSalesOrder('remarks'),
                file: this.getSalesOrder('file'),
                no_po: this.getSalesOrder('no_po'),
                orders_detail: this.getSalesOrder('sales_order_details'),
                file_url: this.$parent.MakeUrl('admin/marketing/form_sales_order/download/' +  this.getSalesOrder('file')),
                qty: [0],
                skuid: '',
                total_amount: [0],
                source_orders: [],
                message: '',
                item: {},
                items: [],
                notes: [],
                errors: [],
                customers: [],
                loading: false,
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                axios.all([
                    axios.get(this.$parent.MakeUrl('api/trx/sales_order_details/' + this.sales_order_id)),
                    axios.get(this.$parent.MakeUrl('api/master_data/price/customer/' + this.customer_id)),
                ]).then(axios.spread((sales_order_details, items) => {
                    this.items = items.data.data;
                    this.qty = [0];
                    this.total_amount = [0];
                    this.notes = [];
                })).catch((err) => {
                    if (err.response.status == 403) {
                        this.$router.push({name: 'form_sales_order'})
                    }
                })
            },
            getSalesOrder(key) {
                return JSON.parse(this.sales_order)[key];
            },
            formatPrice(value) {
                return Number.parseInt(value).toLocaleString('id-ID', {
                    minimumFractionDigits: 2
                });
            },
            getItem() {
                axios.get(this.$parent.MakeUrl('api/master_data/price/' + this.customer_id + '/' + this.skuid)).then((res) => {
                    this.item = res.data.data;
                }).catch((err) => {

                });
            },
            calculateTotalAmount(index) {
                this.orders_detail[index].total_amount =
                    this.orders_detail[index].qty * this.orders_detail[index].amount_price
            },
            pushOrderDetails(skuid) {
                let index = this.orders_detail.length;
                const indexItem = this.orders_detail.findIndex(x => x.skuid === skuid);
                if (indexItem >= 0) {
                    Vue.swal({
                        type: 'error',
                        title: 'ERROR!',
                        text: 'Item Already Added!'
                    });
                    console.log('GAGAL');
                } else {
                    return this.orders_detail.push({
                        skuid: this.item.skuid,
                        qty: 0,
                        total_amount: 0,
                        uom_name: this.item.uom,
                        item_name: this.item.item_name,
                        amount_price: this.item.amount,
                        notes: null
                    });
                }
            },
            removeOrderDetails(index) {
                this.orders_detail.splice(index, 1)
            },
            async submitForm() {
                const payload = {
                    customerId: this.customer_id,
                    salesOrderId: this.sales_order_id,
                    remark: this.remark,
                    // file: this.file,
                    // fulfillmentDate: this.fulfillment_date,
                    // noPO: this.no_po,
                    items: this.orders_detail.map((item, idx) => ({
                        order_details_id: item.id,
                        skuid: item.skuid,
                        qty: item.qty,
                        notes: item.notes
                    }))
                };
                try {
                    const res = await axios.patch('/api/trx/sales_order_details', payload);
                    Vue.swal({
                        type: 'success',
                        title: 'Success!',
                        text: 'Successfully Insert Data!'
                    });
                    console.log(res);
                    // setTimeout(function () {
                    //     window.location.href = '/admin/marketing/form_sales_order';
                    // }, 3000);
                } catch (e) {
                    this.errors = e.response.data.errors;
                }
            }
        },
        components: {
            ModelListSelect
        },
        computed: {
            totalItem: function () {
                let sum = 0;
                this.orders_detail.forEach(function (item) {
                    sum += (parseFloat(item.total_amount));
                });
                return sum.toLocaleString('id-ID', {
                    minimumFractionDigits: 2
                });
            },
        },
    }
</script>
