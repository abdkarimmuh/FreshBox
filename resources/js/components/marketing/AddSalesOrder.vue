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
                                    <input v-bind:class="{'is-invalid': errors.email}" type="text"
                                           v-model="sales_order_no"
                                           class="form-control" placeholder="Sales Order No.">
                                    <div class="invalid-feedback" v-if="errors.email">
                                        <p>{{ errors.email[0] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Customer<span style="color: red;">*</span></label>
                                <div>
                                    <model-list-select :list="customers"
                                                       v-model="customer"
                                                        v-on:input="getData()"
                                                       option-value="id"
                                                       option-text="customer_name"
                                                       placeholder="Select Customer">
                                    </model-list-select>
                                    <div class="invalid-feedback" v-if="errors.customer">
                                        <p>{{ errors.customer[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Source Order</label>
                                <div>
                                    <input v-bind:class="{'is-invalid': errors.source_order}" type="text"
                                           v-model="source_order"
                                           class="form-control" disabled>
                                    <div class="invalid-feedback" v-if="errors.source_order">
                                        <p>{{ errors.source_order[0] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Fulfillment Date</label>
                                <div>
                                    <input v-bind:class="{'is-invalid': errors.fulfillment_date}" type="text"
                                           v-model="fulfillment_date"
                                           class="form-control date-picker" placeholder="Fulfillment Date">
                                    <div class="invalid-feedback" v-if="errors.fulfillment_date">
                                        <p>{{ errors.fulfillment_date[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="customer != 0" class="col-12">
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
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="orders in orders_detail">
                                        <td>{{ orders.sku_id }}</td>
                                        <td>Kol Putih</td>
                                        <td>{{ orders.uom }}</td>
                                        <td style="text-align: right;">{{ orders.qty }}</td>
                                        <td style="text-align: right;">{{ orders.amount_price }}</td>
                                        <td style="text-align: right;">55,550,000.00</td>
                                        <td></td>
                                        <td><a href="#" id="delete|sod|94" role="button" title="Delete"
                                               onclick="deleteSalesOrderDetail(94,);"><span
                                            class="badge badge-pill badge-danger">Delete</span></a></td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align: right;">Grand Total</td>
                                        <td style="text-align: right;">55,600,000.00</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <input type="hidden" id="grandTotal" name="grandTotal" value="55600000"></div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Remark</label>
                                <textarea class="form-control" id="Remarks" name="Remarks"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card-body">
                                <button class="btn btn-primary">Submit</button>
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
                source_order: 'PO',
                fulfillment_date: '',
                sales_order_no: '',
                message: '',
                errors: [],
                customer: '0',
                customers: [],
                orders_detail: [],
                loading: false
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                axios.all([
                    axios.get(this.$parent.MakeUrl('api/customer')),
                    axios.get(this.$parent.MakeUrl('api/sales_order_detail/' + this.customer))
                ]).then(axios.spread((customers, orders_detail) => {
                    this.customers = customers.data;
                    this.orders_detail = orders_detail.data;
                })).catch((err) => {
                    console.log(err)
                })
            },
            addUser() {
                let _this = this;
                _this.errors = [];
                _this.message = '';
                _this.loading = true;
                axios.post(this.$parent.MakeUrl('admin/users'), {
                    'name': this.name,
                    'role': this.role,
                    'email': this.email,
                    'current_password': this.current_password,
                    'password': this.password,
                    'password_confirmation': this.password_confirmation
                }).then((res) => {
                    _this.loading = false;
                    _this.resetForm();
                    _this.message = 'User account has been successfully created!';
                }).catch((err) => {
                    _this.errors = err.response.data.errors;
                    _this.loading = false;
                });
            },
            resetForm() {
                this.name = '';
                this.email = '';
                this.password = '';
                this.role = '';
                this.password_confirmation = '';
            }
        },
        components: {
            ModelListSelect
        }
    }
</script>
