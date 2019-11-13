<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12">
                <div class="card-header">
                    <h4 class="text-danger">Upload Price</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>Customer Group</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <model-list-select
                                        :list="customerGroups"
                                        v-model="form.customerGroupId"
                                        option-value="id"
                                        option-text="name"
                                        placeholder="Select Customer Group"
                                    ></model-list-select>
                                    <div style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                         v-if="errors.customerGroupId">
                                        <p>Customer Group Tidak Boleh Kosong!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- File -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <b>File</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div class="custom-file">
                                    <input
                                        v-bind:class="{'is-invalid': errors.file}"
                                        type="file"
                                        class="custom-file-input"
                                        v-on:change="onFileChange"
                                    />
                                    <label class="custom-file-label">
                                        {{ form.fileName ? form.fileName : 'Choose File'}}
                                    </label>
                                    <div class="invalid-feedback" v-if="errors.file">
                                        <p>Format File Harus : xlsx</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Confirm Date -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <b>Start Period</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <date-picker
                                        v-model="form.startPeriod"
                                        lang="en"
                                        valueType="format">
                                        >
                                    </date-picker>
                                </div>
                                <div style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                     v-if="errors.startPeriod">
                                    <p>Start Period Tidak Boleh Kosong!</p>
                                </div>
                            </div>
                        </div>

                        <!-- End Date -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <b>End Period</b>
                                    <span style="color: red;">*</span>
                                </label>
                                <div>
                                    <date-picker
                                        v-model="form.endPeriod"
                                        lang="en"
                                        valueType="format">
                                        >
                                    </date-picker>
                                </div>
                                <div
                                    style="margin-top: .25rem; font-size: 80%;color: #dc3545"
                                    v-if="errors.endPeriod"
                                >
                                    <p>End Period Tidak Boleh Kosong!</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div v-if="loadingSubmit">
                                <div v-if="showButtonAfterSubmit">
                                    <button
                                        class="btn btn-danger"
                                        v-on:click="submitForm()"
                                    >Generate
                                    </button>
                                </div>
                                <div v-else>
                                    <button-loading></button-loading>
                                </div>
                            </div>
                            <div class="card-body" v-else>
                                <button
                                    class="btn btn-danger"
                                    v-on:click="submitForm()"
                                >Submit
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    onclick="back()"
                                >Back
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ButtonLoading from "../Template/Etc/ButtonLoading";

    export default {
        components: {ButtonLoading},
        data() {
            return {
                form: {
                    startPeriod: "",
                    endPeriod: "",
                    customerGroupId: "",
                    file: "",
                    fileName: "",
                },
                loadingSubmit: false,
                showButtonAfterSubmit: false,
                customerGroups: [],
                errors: []
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            onFileChange(e) {
                let fileData = e.target.files || e.dataTransfer.files;
                this.form.fileName = fileData[0].name;
                this.form.file = fileData[0];
            },
            getData() {
                axios.get(this.$parent.MakeUrl("api/v1/master_data/customer-group"))
                    .then(res => {
                        console.log(res);
                        this.customerGroups = res.data;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            async submitForm() {
                this.loadingSubmit = true;
                var fData = new FormData();
                fData.set('startPeriod', this.form.startPeriod);
                fData.set('endPeriod', this.form.endPeriod);
                fData.set('customerGroupId', this.form.customerGroupId);
                fData.set('file', this.form.file);
                try {
                    const res = await axios(
                        {
                            method: 'post',
                            url: this.$parent.MakeUrl("api/v1/import-data-price-temp"),
                            data: fData,
                            config: {headers: {'Content-Type': 'multipart/form-data'}}
                        }
                    );
                    Vue.swal({
                        type: "success",
                        title: "Success!",
                        text: "Successfully Confirm Delivery Order!"
                    }).then(next => {
                        this.loadingSubmit = false;
                        this.showButtonAfterSubmit = true;
                        window.location.href = "/admin/warehouse/confirm_delivery_order";
                    });
                    console.log(res);
                } catch (e) {
                    this.loadingSubmit = false;
                    this.errors = e.response.data.errors;
                    console.error(e.response.data);
                }
            },

        }
    };
</script>

