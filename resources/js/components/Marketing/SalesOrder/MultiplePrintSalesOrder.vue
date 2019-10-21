<template>
    <div>
        <div class="card card-body">
            <div class="text-right">
                <button
                    class="btn btn-secondary"
                    type="button"
                    @click="back()"
                > Back
                </button>
                <button
                    class="btn btn-success"
                    @click="print"
                > Print
                </button>
            </div>
        </div>
        <div id="printMe">
            <div style="page-break-after: always" v-for="(item, index) in sales_order">
                <print-header></print-header>
                <div class="row" v-if="loading">
                    <div class="col-md-12">
                        <print-header-info :header_info="header_info" :data="item"
                                           :info="info"></print-header-info>
                        <br>
                        <print-table :columns="columns" :data="item.sales_order_details"></print-table>
                        <div class="col-md-12 mt-2">
                            <table width="100%" style="border-top: 1px solid black;">
                                <tbody>
                                <tr>
                                    <td width="56%">Keterangan :</td>
                                    <td style="border-bottom: 1px solid black;" class="text-right">Subtotal Rp</td>
                                    <td style="border-bottom: 1px solid black;" class="text-right">{{
                                        item.total_price | toIDR }}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="56%"></td>
                                    <td style="border-bottom: 1px solid black;" class="text-right">Discount Rp</td>
                                    <td style="border-bottom: 1px solid black;" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td width="56%"></td>
                                    <td style="border-bottom: 1px solid black;" class="text-right">Pajak Rp</td>
                                    <td style="border-bottom: 1px solid black;" class="text-right"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid black;">
                                    <td width="56%"></td>
                                    <td class="text-right">Total Rp</td>
                                    <td class="text-right">{{
                                        item.total_price | toIDR }}
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid;" width="100%" height="22px">
                                    <td width="56%"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                </tr>
                                <tr style="border-bottom: 1px solid;" width="100%" height="22px">
                                    <td width="56%"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 mt-1">
                            <div class="row">
                                <div class="col-md-3">
                                    <h6>Disiapkan oleh,</h6>
                                </div>
                                <div class="col-md-3">
                                    <h6>Driver,</h6>
                                </div>
                                <div class="col-md-3">
                                    <h6>Diterima oleh,</h6>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="text-center p-4 text-muted" v-else>
                    <h5>Loading</h5>
                    <p>Please wait, data is being loaded...</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                info: {
                    title: "Sales Order",
                    no: "sales_order_no",
                },
                columns: [
                    {
                        title: 'Item No',
                        field: 'skuid',
                        type: 'text',
                    },
                    {
                        title: 'Item Name',
                        field: 'item_name',
                        type: 'text',
                    },
                    {
                        title: 'Qty',
                        field: 'qty',
                        type: 'text',
                    },
                    {
                        title: 'Unit',
                        field: 'uom_name',
                        type: 'text',
                    },
                    {
                        title: 'Price',
                        field: 'amount_price_formatted',
                        type: 'currency',
                    },
                    {
                        title: 'Amount',
                        field: 'total_amount_formatted',
                        type: 'currency',
                    },
                ],
                header_info: [
                    {
                        title: "Sales Order Date",
                        field: "fulfillment_date",
                    },
                    {
                        page_break: true,
                    },
                    {
                        title: "Kepada Yth",
                        field: "",
                    },
                    {
                        title: "PO No.",
                        field: "no_po",
                    },
                    {
                        title: "Customer",
                        field: "customer_name",
                    },

                ],
                sales_order: [],
                loading: false,
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                const payload = {
                    id: this.$route.query.id,
                };
                axios.get(this.$parent.MakeUrl('api/v1/marketing/sales_order/show'), {params: payload})
                    .then(res => {
                        this.sales_order = res.data;
                        this.loading = true;
                    }).catch(e => {
                    if (e.response.status === 500) {
                        this.getData()
                    }
                });
            },
            print() {
                const payload = {
                    id: this.$route.query.id,
                };
                Vue.swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Print it!'
                }).then((result) => {
                    if (result.value) {
                        this.$htmlToPaper('printMe');
                        const res = axios.post(this.$parent.MakeUrl('api/v1/marketing/sales_order/print'), payload);
                        console.log(res);
                    }
                })
            },
            back() {
                this.$router.push({name: 'form_sales_order'})
            }
        }
    }
</script>

