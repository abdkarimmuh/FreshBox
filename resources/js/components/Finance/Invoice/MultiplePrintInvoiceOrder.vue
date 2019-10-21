<template>
    <div>
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
        <div id="printMe">
            <div style="page-break-after: always" v-for="(item, index) in invoice_order">
                <print-header></print-header>
                <div class="row" v-if="loading">
                    <div class="col-md-12">
                        <print-header-info :header_info="header_info" :data="item"
                                           :info="info"></print-header-info>
                        <br>
                        <print-table :columns="columns" :data="item.do_details"></print-table>
                        <div class="col-md-12">
                            <table width="100%" style="border-top: 1px solid black">
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
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="text-right mr-2">
                                <h6><b>{{ info.nama_pt }}</b></h6>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div class="mr-5">
                                    <h6>{{ info.nama_ttd }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table width="60%">
                                <tbody>
                                <tr>
                                    <td width="10%" class="text-right"><b><h6>Harap transfer ke</h6></b></td>
                                    <td width="2%">&nbsp:</td>
                                    <td width="30%"></td>
                                </tr>
                                <tr>
                                    <td width="2%" class="text-right"><b>Penerima</b></td>
                                    <td width="2%">&nbsp:</td>
                                    <td width="30%">{{ info.nama_pt }}</td>
                                </tr>
                                <tr>
                                    <td width="2%" class="text-right"><b>No Rekening</b></td>
                                    <td width="2%">&nbsp:</td>
                                    <td width="30%">{{ info.no_rek }}</td>
                                </tr>
                                <tr>
                                    <td width="2%" class="text-right"><b>Bank</b></td>
                                    <td width="2%">&nbsp:</td>
                                    <td width="30%">{{ info.bank }}</td>
                                </tr>
                                <tr>
                                    <td><br></td>
                                </tr>
                                <tr>
                                    <td width="10%" colspan="5"><b>*) Pembayaran dianggap sah jika bukti transfer sudah
                                        dikirimkan kepada kami</b></td>
                                </tr>
                                </tbody>
                            </table>
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
                    title: "Invoice",
                    no: "invoice_no",
                    nama_pt: "PT BERKAH TANI SEJAHTERA",
                    nama_ttd: "Faizal Finanda",
                    no_rek: "006 500 9779",
                    bank: "BCA Cabang SCBD"
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
                        field: 'qty_confirm',
                        type: 'text',
                    },
                    {
                        title: 'Unit',
                        field: 'uom_name',
                        type: 'text',
                    },
                    {
                        title: 'Price',
                        field: 'amount_price',
                        type: 'currency',
                    },
                    {
                        title: 'Amount',
                        field: 'total_amount',
                        type: 'currency',
                    },
                ],
                header_info: [
                    {
                        title: "Invoice Date",
                        field: "invoice_date",
                    },
                    {
                        title: "Delivery Order No",
                        field: "delivery_order_no",
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
                invoice_order: [],
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
                axios.get(this.$parent.MakeUrl('api/v1/finance/invoice_order/show'), {params: payload})
                    .then(res => {
                        this.invoice_order = res.data;
                        this.loading = true;
                    })
                    .catch(e => {
                        if (e.response.status == 500) {
                            this.getData();
                        }
                    })
            },
            async print() {
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
                        axios.post(this.$parent.MakeUrl('api/v1/finance/invoice_order/print'), payload);
                    }
                })


            },
            back() {
                return window.location.href = this.$parent.MakeUrl('admin/finance/invoice_order');
            }
        }
    }
</script>

