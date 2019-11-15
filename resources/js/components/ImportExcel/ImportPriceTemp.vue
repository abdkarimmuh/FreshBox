<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12" v-if="!showButtonAfterSubmit">
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
                                    <span style="color: red;">*file harus type xlsx</span>
                                </label>
                                <div class="custom-file">
                                    <input
                                        v-bind:class="{'is-invalid': errors.file}"
                                        type="file"
                                        class="custom-file-input"
                                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                        v-on:change="onFileChange"
                                    />
                                    <label class="custom-file-label">
                                        {{ form.fileName ? form.fileName : 'Choose File'}}
                                    </label>
                                    <div class="invalid-feedback" v-if="errors.file">
                                        <p>File Tidak Boleh Kosong!</p>
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
                                <div style="margin-top: .25rem; font-size: 80%;color: #dc3545" v-if="errors.endPeriod">
                                    <p>End Period Tidak Boleh Kosong!</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div v-if="loadingSubmit">
                                <button-loading></button-loading>
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
                                    onclick="history.back()"
                                >Back
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-12 text-center" v-if="showButtonAfterSubmit">
                <div class="card-header">
                    <h4 class="text-danger">Generate Master Price</h4>
                    <button class="btn btn-sm btn-danger" v-on:click="generateMasterPrice()">
                        Generate
                    </button>
                </div>
                <div class="card-header">
                    <h4 class="text-danger">List Duplicate Data</h4>
                </div>
                <div v-if="duplicateData.length" class="col-12">
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover" style="font-size: 9pt;">
                            <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Items</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Pricelist</th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Final</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in duplicateData" track-by="index" v-bind:key="index">
                                <td>{{ item.No }}</td>
                                <td>{{ item.SKU }}</td>
                                <td>{{ item.Category }}</td>
                                <td>{{ item.Items }}</td>
                                <td>{{ item.Unit }}</td>
                                <td>{{ item.Pricelist }}</td>
                                <td>{{ item.Discount }}</td>
                                <td>{{ item.Final }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 text-center">

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
                duplicateData: [],
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
                        this.customerGroups = res.data;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            async submitForm() {
                this.loadingSubmit = true;
                let fData = new FormData();
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
                    this.duplicateData = res.data.duplicate;
                    Vue.swal({
                        type: 'success',
                        title: "Success!",
                        text: "Successfully Upload Price Data!"
                    }).then(next => {
                        this.loadingSubmit = false;
                        this.showButtonAfterSubmit = true;
                    });
                } catch (e) {
                    this.loadingSubmit = false;
                    this.errors = e.response.data.errors;
                    console.error(e.response.data);
                }
            },
            generateMasterPrice() {
                Vue.swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, generate it!'
                }).then((result) => {
                    if (result.value) {
                        Vue.swal(
                            'Generated!',
                            'Master Price has been generated.',
                            'success'
                        ).then(next => {
                            window.location.href = "/admin/import/price";
                        });
                        try {
                            const res = axios(
                                {
                                    method: 'post',
                                    url: this.$parent.MakeUrl("api/v1/import-data-price-temp/generate"),
                                }
                            );
                            console.log(res);
                        } catch (e) {
                            console.error(e.response.data);
                        }
                    }
                })
            },
        }
    };
</script>

