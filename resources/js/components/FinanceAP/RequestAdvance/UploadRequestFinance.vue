<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12" v-if="!loading">
                <div class="card-header">
                    <h4 class="text-danger">
                        Upload Dokumen Request Cash Advance
                    </h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <b>File</b>
                                </label>
                                <div class="custom-file">
                                    <input
                                        v-bind:class="{
                                            'is-invalid': errors.file
                                        }"
                                        type="file"
                                        name="site_logo"
                                        class="custom-file-input"
                                        id="site-logo"
                                        v-on:change="onFileChange"
                                    />
                                    <label class="custom-file-label">
                                        {{
                                            fileName ? fileName : "Choose File"
                                        }}
                                    </label>
                                    <div
                                        class="invalid-feedback"
                                        v-if="errors.file"
                                    >
                                        <p>{{ errors.file[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card-body">
                                <div v-if="loadingSubmit">
                                    <loading-button />
                                </div>
                                <div v-else>
                                    <button
                                        class="btn btn-danger"
                                        v-on:click="submitForm()"
                                        v-if="file !== ''"
                                    >
                                        Submit
                                    </button>
                                    <back-button />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card col-12" v-else>
                <loading-table />
            </div>
        </div>
    </div>
</template>
<script>
import { ModelListSelect } from "vue-search-select";

export default {
    data() {
        return {
            fileName: "",
            file: "",
            errors: [],
            loading: false,
            loadingSubmit: false
        };
    },
    mounted() {},
    methods: {
        async submitForm() {
            this.loadingSubmit = true;
            const payload = {
                file: this.file
            };
            try {
                const res = await axios.post(
                    "/api/v1/finance-ap/request-advance/upload/" +
                        this.$route.params.id,
                    payload
                );
                Vue.swal({
                    type: "success",
                    title: "Success!",
                    text: "Successfully Upload Document!"
                }).then(next => {
                    this.$router.push({ name: "finance.requestAdvance" });
                });
                console.log(res);
            } catch (e) {
                this.loadingSubmit = false;
                this.errors = e.response.data.errors;
                console.error(e.response.data);
            }
        },

        onFileChange(e) {
            let fileData = e.target.files || e.dataTransfer.files;
            this.fileName = fileData[0].name;
            if (!fileData.length) return;
            this.createFile(fileData[0]);
        },

        createFile(file) {
            let reader = new FileReader();
            reader.onload = e => {
                this.file = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    },
    components: {
        ModelListSelect
    }
};
</script>
