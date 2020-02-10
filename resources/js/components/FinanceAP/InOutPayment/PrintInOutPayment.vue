<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="text-danger" v-if="data.type == 1">IN PAYMENT</h4>
                <h4 class="text-danger" v-else>OUT PAYMENT</h4>
                <div class="card-header-action">
                    <back-button />
                    <!-- <button class="btn btn-success" @click="print">
                        Print
                    </button> -->
                </div>
            </div>
        </div>
        <div class="card card-body printableArea" id="printMe">
            <div class="row" v-if="loading">
                <div class="col-md-12 mr-4 ml-4 mt-4 mb-4">
                    <div class="row">
                        <div class="col-md-4 mt-4">
                            <div>Source Data</div>
                            <h5>{{ data.source_data }}</h5>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div>Type Transaction</div>
                            <h5>{{ data.type_transaction }}</h5>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div>Option Transaction</div>
                            <span v-html="data.option_transaction"></span>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div>Amount</div>
                            <h5>Rp {{ data.amount | toIDR }}</h5>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div>Bank Name</div>
                            <h5>{{ data.bank_name }}</h5>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div>Bank Account</div>
                            <h5>{{ data.bank_account }}</h5>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div>Status</div>
                            <span v-html="data.status_html"></span>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div>Transaction Date</div>
                            <h5>{{ data.transaction_date }}</h5>
                        </div>
                        <div
                            class="col-md-4 mt-4"
                            v-if="data.file !== '' && data.file !== null"
                        >
                            <div>File</div>
                            <a
                                href="#"
                                class="badge badge-info"
                                @click="showFile(data.file_url, data.file)"
                            >
                                {{ data.file }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="loading">
                <div
                    class="col-md-12 mr-4 ml-4 mt-4 mb-4"
                    v-if="data.remarks != '' && data.remarks != null"
                >
                    <div>Remarks</div>
                    <h5>{{ data.remarks }}</h5>
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
            data: {},
            loading: false
        };
    },
    mounted() {
        this.getInOutPayment();
    },
    methods: {
        getInOutPayment() {
            axios
                .get(
                    this.$parent.MakeUrl(
                        "api/v1/finance-ap/in-out-payment/show/" +
                            this.$route.params.id
                    )
                )
                .then(res => {
                    this.data = res.data;
                    this.loading = true;
                    console.log(res.data);
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
        },
        showFile(fileUrl, fileName) {
            Vue.swal({
                title: fileName,
                imageUrl: fileUrl,
                imageAlt: "Custom image"
            });
            console.log(fileUrl);
        }
    },
    computed: {
        subTotal: function() {
            let sum = 0;
            this.invoices.forEach(function(item) {
                sum += item.price;
            });
            return sum;
        }
    }
};
</script>

<style>
.table-centered {
    margin: 0 auto;
}
</style>
