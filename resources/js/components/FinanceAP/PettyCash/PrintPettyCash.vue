<template>
    <div>
        <div class="text-right">
            <button class="btn btn-secondary" type="button" onlclick="history.back()">Back</button>
            <button class="btn btn-success" @click="print">Print</button>
        </div>
        <div class="card card-body printableArea" id="printMe">
            <h3>
                <span class="logo-text">
                    <img
                        v-bind:src="$parent.MakeUrl('assets/img/logo-frbox.png')"
                        alt="homepage"
                        class="light-logo"
                    />
                </span>
            </h3>
            <div class="row" v-if="loading">
                <div class="col-md-12">
                    <div class="text-center">
                        <h4>
                            <b
                                style="color: black; text-decoration: underline"
                            >FORM PERMINTAAN PETTY CASH</b>
                        </h4>
                    </div>
                    <br />
                    <br />
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td width="13%">
                                                    <b>No</b>
                                                </td>
                                                <td width="2%">:</td>
                                                <td width="40%">{{ pettyCash.no_request }}</td>
                                            </tr>
                                            <tr>
                                                <td width="13%">
                                                    <b>Tanggal</b>
                                                </td>
                                                <td width="2%">:</td>
                                                <td width="40%">{{ pettyCash.created_at }}</td>
                                            </tr>
                                            <tr>
                                                <td width="13%">
                                                    <b>Jenis Permintaan</b>
                                                </td>
                                                <td width="2%">:</td>
                                                <td width="40%">Petty Cash</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="table-responsive">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td width="13%">
                                                    <b>Nama</b>
                                                </td>
                                                <td width="2%">:</td>
                                                <td width="40%">{{ pettyCash.user_request_name }}</td>
                                            </tr>
                                            <tr>
                                                <td width="13%">
                                                    <b>Dept</b>
                                                </td>
                                                <td width="2%">:</td>
                                                <td width="40%">{{ pettyCash.dept }}</td>
                                            </tr>
                                            <tr>
                                                <td width="25%">
                                                    <b>Alamat Kirim</b>
                                                </td>
                                                <td width="2%">:</td>
                                                <td width="40%">{{ pettyCash.address }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="col-md-12">
                        <table border="1" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Jenis Barang</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center" colspan="2">Harga + PPn</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Nama Supplier</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in details">
                                    <td class="text-center">{{ index + 1}}</td>
                                    <td class="text-left">{{ item.itemName }}</td>
                                    <td class="text-center">{{ item.typeOfGoods }}</td>
                                    <td class="text-center">{{ item.qty }}</td>
                                    <td class="text-center">{{ item.uom_name }}</td>
                                    <td class="text-right">{{ item.price | toIDR }}</td>
                                    <td class="text-right" width="100">{{ item.ppn | toIDR }}</td>
                                    <td class="text-right">{{ item.total | toIDR }}</td>
                                    <td class="text-left">{{ item.supplierName }}</td>
                                    <td class="text-left">{{ item.remarks }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td height="20"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>TOTAL</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">{{ pettyCash.total | toIDR}}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <br />
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table width="100%" style="color: black">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <b style="text-decoration: underline">Terbilang</b>
                                                    &nbsp;
                                                    &nbsp;&nbsp; {{ pettyCash.terbilang }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table width="100%" style="color: black">
                                        <tbody>
                                            <tr>
                                                <td width="70">
                                                    <b>No Rek</b>
                                                </td>
                                                <td>{{ pettyCash.noRek }}</td>
                                            </tr>
                                            <tr>
                                                <td width="50"></td>
                                                <td>{{ pettyCash.namaRek }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <br />
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-left ml-4">
                                    <h6>Diajukan Oleh,</h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right mr-4">
                                    <h6>Disetujui oleh,</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <br />
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">(........................................)</div>
                            <div class="col-md-6">
                                <div class="text-right">(........................................)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center p-4 text-muted" v-else>
                <h5>Loading</h5>
                <p>Please wait, data is being loaded...</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["id"],
    data() {
        return {
            pettyCash_id: "",
            pettyCash: {},
            details: [],
            loading: false
        };
    },
    mounted() {
        this.getPettyCash();
    },
    methods: {
        getPettyCash() {
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/finance-ap/petty-cash/show/" +
                            this.$route.params.id
                    )
                )
                .then(res => {
                    console.log(res.data);
                    this.pettyCash = res.data;
                    this.details = res.data.details;
                    console.log(this.pettyCash);
                    this.loading = true;
                })
                .catch(e => {});
        },
        print() {
            Vue.swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Print it!"
            }).then(result => {
                if (result.value) {
                    this.$htmlToPaper("printMe");
                    // axios.post(this.$parent.MakeUrl('admin/finance/invoice_order/' + this.id + '/print'))
                }
            });
        }
    }
};
</script>

<style>
.table-centered {
    margin: 0 auto;
}
</style>
