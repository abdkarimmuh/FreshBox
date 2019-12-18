<template>
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row" v-if="loading">
            <div class="col-md-12 text-center">
                <LoadingTable />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Order</h4>
                        </div>
                        <div class="card-body">{{totalOrder}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-clipboard"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Submitted Invoice</h4>
                        </div>
                        <div class="card-body">{{submittedInvoice}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Paid Invoice</h4>
                        </div>
                        <div class="card-body">{{paidInvoice}}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import LoadingTable from "./Template/Table/partials/LoadingTable";
export default {
    data() {
        return {
            totalOrder: 0,
            submittedInvoice: 0,
            paidInvoice: 0,
            loading: false
        };
    },
    async mounted() {
        this.loading = true;
        await this.getData();
    },
    methods: {
        getData() {
            axios
                .get(this.$parent.MakeUrl("api/v1/dashboard/all"))
                .then(res => {
                    console.log(res);
                    this.totalOrder = res.data.totalOrder;
                    this.submittedInvoice = res.data.submittedInvoice;
                    this.paidInvoice = res.data.paidInvoice;
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    components: {
        LoadingTable
    }
};
</script>
