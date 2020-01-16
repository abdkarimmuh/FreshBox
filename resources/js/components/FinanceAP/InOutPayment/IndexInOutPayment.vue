<template>
  <div v-if="$parent.userRole('Admin')">
    <s-table :config="config" :columns="columns" />
  </div>
  <div v-else>
    <s-error-page :error="error" />
  </div>
</template>
<script>
export default {
  data() {
    return {
      config: {
        title: "In/Out Payment",
        action: true,
        base_url: this.$parent.MakeUrl("api/v1/finance-ap/in-out-payment"),
        route_create: "form_sales_order.create",
        route_confirm_in_out_payment: "finance.inOutPayment.show",
        route_done_in_out_payment: "finance.inOutPayment.show"
      },
      columns: [
        {
          title: "Nama Vendor",
          field: "vendor",
          filterable: true
        },
        {
          title: "Tipe Transaksi",
          field: "type_transaction",
          type: "html"
        },
        {
          title: "Bank",
          field: "bank_name",
          filterable: true
        },
        {
          title: "Jumlah",
          field: "amount",
          filterable: false
        },
        {
          title: "Status",
          field: "status_html",
          filterable: true,
          type: "html"
        },

        {
          title: "Remark",
          field: "remarks",
          filterable: false
        }
      ],
      error: {
        code: 403,
        description: "You do not have access to this page"
      }
    };
  }
};
</script>
