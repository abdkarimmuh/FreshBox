<template>
    <div>
        <div class="card card-body">
            <div class="text-right">
                <button
                    class="btn btn-secondary"
                    type="button"
                    onclick="history.back()"
                >
                    Back
                </button>
                <button class="btn btn-success" @click="print">Print</button>
            </div>
        </div>
        <div id="printMe">
            <div class="row" v-if="loading">
                <div class="col-md-12">
                    <div class="row">
                        <div
                            v-for="(item, index) in do_detail"
                            :key="index"
                            class="col-md-4"
                        >
                            <p>{{ item.fullfilment_date }}</p>
                            <barcode
                                v-bind:value="item.barcode"
                                format="CODE39"
                            >
                                Show this if the rendering fails.
                            </barcode>
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
    data() {
        return {
            do_detail: [],
            loading: false
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            const payload = {
                id: this.$route.query.id
            };
            axios
                .get(
                    this.$parent.MakeUrl("api/v1/warehouseIn/packageItem/show"),
                    { params: payload }
                )
                .then(res => {
                    this.do_detail = res.data;
                    this.loading = true;
                    console.log(res);
                })
                .catch(e => {
                    if (e.response.status === 500) {
                        this.getData();
                    }
                });
        },
        print() {
            const payload = {
                id: this.$route.query.id
            };
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
                    const res = axios.post(
                        this.$parent.MakeUrl(
                            "api/v1/warehouseIn/packageItem/print"
                        ),
                        payload
                    );
                    console.log(res);
                    console.log(payload);
                }
            });
        }
    }
};
</script>
