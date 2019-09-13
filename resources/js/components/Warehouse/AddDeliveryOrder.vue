<template>
  <div class="row">
    <div class="col-12">
      <div class="card col-12">
        <div class="card-header">
          <h4 class="text-danger">Sales Order Details</h4>
        </div>
        <div class="col-12">
          <div class="row">
            <!-- Sales Order No -->
            <div class="col-md-6">
              <div class="form-group">
                <label>
                  <b>Sales Order No</b>
                  <span style="color: red;">*</span>
                </label>
                <div>
                  <model-list-select
                    v-bind:class="{'is-invalid': errors.customerId}"
                    :list="customers"
                    v-model="customer_id"
                    v-on:input="getData()"
                    option-value="id"
                    option-text="name"
                    placeholder="Select Customer"
                  ></model-list-select>
                  <div
                    style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                    v-if="errors.customerId"
                  >
                    <p>{{ errors.customerId[0] }}</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- DO Date -->
            <div class="col-md-6">
              <div class="form-group">
                <label>
                  <b>DO Date</b>
                  <span style="color: red;">*</span>
                </label>

                <div>
                  <date-picker
                    v-model="fulfillment_date"
                    lang="en"
                    valuetype="format"
                    :not-before="new Date()"
                  ></date-picker>
                </div>
                <div
                  style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                  v-if="errors.fulfillmentDate"
                >
                  <p>{{ errors.fulfillmentDate[0] }}</p>
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
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(orders, index) in orders_detail" v-bind:key="index">
                      <td>{{ orders.skuid }}</td>
                      <td>{{ orders.item_name }}</td>
                      <td style="text-align: right;">
                        <input
                          v-model="qty[index]"
                          type="number"
                          placeholder="Qty"
                          min="0"
                          oninput="validity.valid||(value='');"
                          class="form-control qty"
                        />
                      </td>
                      <td>{{ orders.uom }}</td>
                      <td style="text-align: right;">{{ formatPrice(orders.amount) }}</td>
                      <td style="text-align: right">{{ formatPrice(total_amount[index]) }}</td>
                      <td>
                        <input
                          v-model="notes[index]"
                          type="text"
                          placeholder="Notes"
                          class="form-control"
                        />
                      </td>
                      <td>
                        <button
                          class="btn btn-icon btn-sm btn-danger"
                          @click="removeOrderDetails(index)"
                        >
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

              <div v-for="(orders, index) in orders_detail" v-bind:key="index">
                <div
                  style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                  v-if="errors[`items.${index}.qty`]"
                >
                  <p>{{errors[`items.${index}.qty`][0] }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>
                  <b>Remarks</b>
                </label>
                <textarea
                  v-bind:class="{'is-invalid': errors.remark}"
                  v-model="remark"
                  class="form-control"
                  id="Remarks"
                  name="Remarks"
                ></textarea>
                <div class="invalid-feedback" v-if="errors.remark">
                  <p>{{ errors.remark[0] }}</p>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card-body">
                <button class="btn btn-danger" v-on:click="submitForm()">Submit</button>
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
import { ModelListSelect } from "vue-search-select";

export default {
  props: ["user_id"],
  data() {
    return {
      qty: [0],
      remark: "",
      no_po: "",
      skuid: "",
      total_amount: [0],
      source_order_id: 0,
      source_orders: [],
      fulfillment_date: "",
      fileName: "",
      file: "",
      item: {},
      items: [],
      notes: [],
      errors: [],
      customer_id: 0,
      customers: [],
      orders_detail: [],
      loading: false
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    async submitForm() {
      const payload = {
        user_id: this.user_id,
        customerId: this.customer_id,
        remark: this.remark,
        file: this.file,
        fulfillmentDate: this.fulfillment_date,
        sourceOrderId: this.source_order_id,
        no_po: this.no_po,
        items: this.orders_detail.map((item, idx) => ({
          skuid: item.skuid,
          qty: this.qty[idx],
          notes: this.notes[idx]
        }))
      };
      try {
        const res = await axios.post(
          "/api/marketing/sales_order_detail",
          payload
        );
        Vue.swal({
          type: "success",
          title: "Success!",
          text: "Successfully Insert Data!"
        });
        setTimeout(function() {
          window.location.href = "/admin/marketing/form_sales_order";
        }, 2500);
        console.log("RES SALES ORDER", res);
      } catch (e) {
        this.errors = e.response.data.errors;
        console.error(e.response.data);
      }
    },
    onFileChange(e) {
      var fileData = e.target.files || e.dataTransfer.files;
      this.fileName = fileData[0].name;
      if (!fileData.length) return;
      this.createFile(fileData[0]);
      // console.log(fileData);
    },
    createFile(file) {
      let reader = new FileReader();
      reader.onload = e => {
        this.file = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    formatPrice(value) {
      return value.toLocaleString("id-ID", {
        minimumFractionDigits: 2
      });
    },
    getItem() {
      axios
        .get(
          this.$parent.MakeUrl(
            "api/master_data/price/" + this.customer_id + "/" + this.skuid
          )
        )
        .then(res => {
          this.item = res.data.data;
          console.log(this.item);
        })
        .catch(err => {});
    },
    pushOrderDetails(skuid) {
      const indexItem = this.orders_detail.findIndex(x => x.skuid === skuid);
      if (indexItem >= 0) {
        Vue.swal({
          type: "error",
          title: "ERROR!",
          text: "Item Already Added!"
        });
        console.log("GAGAL");
      } else {
        let index = this.orders_detail.length;
        this.total_amount[index] = 0;
        this.qty[index] = 0;
        this.notes[index] = null;
        return this.orders_detail.push({
          skuid: this.item.skuid,
          qty: 0,
          uom: this.item.uom,
          item_name: this.item.item_name,
          amount: this.item.amount,
          notes: null
        });
      }
    },
    removeOrderDetails(index) {
      this.orders_detail.splice(index, 1);
    },
    getData() {
      axios
        .all([
          axios.get(this.$parent.MakeUrl("api/master_data/customer/list")),
          axios.get(this.$parent.MakeUrl("api/master_data/source_order/list")),
          axios.get(
            this.$parent.MakeUrl(
              "api/master_data/price/customer/" + this.customer_id
            )
          )
        ])
        .then(
          axios.spread((customers, source_order, items) => {
            this.customers = customers.data;
            this.source_orders = source_order.data;
            this.items = items.data.data;
            this.orders_detail = [];
            this.qty = [0];
            this.total_amount = [0];
            this.notes = [];
          })
        )
        .catch(err => {
          if (err.response.status == 403) {
            this.$router.push({ name: "form_sales_order" });
          }
        });
    }
  },
  components: {
    ModelListSelect
  },
  computed: {
    totalItem: function() {
      let sum = 0;
      this.total_amount.forEach(function(item) {
        sum += parseFloat(item);
      });

      return sum.toLocaleString("id-ID", {
        minimumFractionDigits: 2
      });
    }
  },
  watch: {
    qty: function(newQty, oldQty) {
      this.total_amount = this.orders_detail.map(
        (item, idx) => item.amount * (newQty[idx] || 0)
      );
    }
  }
};
</script>

