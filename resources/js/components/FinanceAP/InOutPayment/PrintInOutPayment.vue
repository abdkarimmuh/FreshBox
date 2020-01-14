<template>
  <div>
    <div class="card card-body printableArea" id="printMe">
      <div class="card-header">
        <h4 class="text-danger" v-if="data.status == 2">IN PAYMENT</h4>
        <h4 class="text-danger" v-else>OUT PAYMENT</h4>
        <div class="card-header-action">
          <back-button />
          <button class="btn btn-success" @click="print">Print</button>
        </div>
      </div>

      <hr />
      <div class="row" v-if="loading">
        <div class="col-md-12">
          <br />
          <div class="col-md-12" v-if="data.status == 2">
            <div class="row">
              <div class="col-md-6">
                <h6 class="mt-6">Vendor Name</h6>
                <h3>
                  <small class="text-muted">{{data.vendor_name}}</small>
                </h3>
              </div>

              <div class="col-md-6">
                <h6 class="mt-6">Jumlah</h6>
                <h3>
                  <small class="text-muted">{{data.amount | toIDR}}</small>
                </h3>
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-md-6">
                <h6 class="mt-6">Created At</h6>
                <h3>
                  <small class="text-muted">{{data.created_at}}</small>
                </h3>
              </div>

              <div class="col-md-6">
                <h6 class="mt-6">Tipe Transaksi</h6>
                <h3>
                  <small class="text-muted">{{data.type_transaction}}</small>
                </h3>
              </div>
            </div>
          </div>

          <div class="col-md-12" v-else>
            <div class="row">
              <div class="col-md-6">
                <h6 class="mt-6">Vendor Name</h6>
                <h3>
                  <small class="text-muted">{{data.vendor_name}}</small>
                </h3>
              </div>

              <div class="col-md-6">
                <h6 class="mt-6">No. Rekening</h6>
                <h3>
                  <small class="text-muted">{{data.no_rek}}</small>
                </h3>
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-md-6">
                <h6 class="mt-6">PPn</h6>
                <h3>
                  <small class="text-muted">{{data.ppn}}</small>
                </h3>
              </div>

              <div class="col-md-6">
                <h6 class="mt-6">PPh</h6>
                <h3>
                  <small class="text-muted">{{data.pph}}</small>
                </h3>
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-md-6">
                <h6 class="mt-6">No. Invoice</h6>
                <h3>
                  <small class="text-muted">{{data.no_invoice}}</small>
                </h3>
              </div>

              <div class="col-md-6">
                <h6 class="mt-6">Created at</h6>
                <h3>
                  <small class="text-muted">{{data.created_at}}</small>
                </h3>
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
            "api/v1/finance-ap/in-out-payment/show/" + this.$route.params.id
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
