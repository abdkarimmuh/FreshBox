<template>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-primary" v-if="message">{{ message }}</div>
            <div class="card">
                <div class="card-header">
                    <h4 class="text-danger">Add a New User Proc</h4>
                </div>
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
                        <div class="col-sm-12 col-md-7">
                            <input
                                v-bind:class="{'is-invalid': errors.name}"
                                type="text"
                                v-model="name"
                                class="form-control"
                                placeholder="Full name of the user."
                            />
                            <div class="invalid-feedback" v-if="errors.name">
                                <p>{{ errors.name[0] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                        <div class="col-sm-12 col-md-7">
                            <input
                                v-bind:class="{'is-invalid': errors.email}"
                                type="text"
                                v-model="email"
                                class="form-control"
                                placeholder="Email address (should be unique)."
                            />
                            <div class="invalid-feedback" v-if="errors.email">
                                <p>{{ errors.email[0] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label
                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3"
                        >Bank Account</label>
                        <div class="col-sm-12 col-md-7">
                            <input
                                v-bind:class="{'is-invalid': errors.bank_account}"
                                type="text"
                                v-model="bank_account"
                                class="form-control"
                                placeholder="Set an bank account"
                            />
                            <div class="invalid-feedback" v-if="errors.bank_account">
                                <p>{{ errors.bank_account[0] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bank</label>
                        <div class="col-sm-12 col-md-7">
                            <select
                                class="form-control"
                                v-model="bank"
                                v-bind:class="{'is-invalid': errors.bank}"
                            >
                                <option v-for="bank in banks" v-bind:value="bank.id">{{ bank.name }}</option>
                            </select>
                            <div class="invalid-feedback" v-if="errors.bank">
                                <p>{{ errors.bank[0] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Origin</label>
                        <div class="col-sm-12 col-md-7">
                            <select
                                class="form-control"
                                v-model="origin"
                                v-bind:class="{'is-invalid': errors.origin}"
                            >
                                <option
                                    v-for="origin in origins"
                                    v-bind:value="origin.id"
                                >{{ origin.description }}</option>
                            </select>
                            <div class="invalid-feedback" v-if="errors.origin">
                                <p>{{ errors.origin[0] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label
                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3"
                        >Category</label>
                        <div class="col-sm-12 col-md-7">
                            <select
                                class="form-control"
                                v-model="category"
                                v-bind:class="{'is-invalid': errors.category}"
                            >
                                <option
                                    v-for="category in categories"
                                    v-bind:value="category.id"
                                >{{ category.name }}</option>
                            </select>
                            <div class="invalid-feedback" v-if="errors.category">
                                <p>{{ errors.category[0] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label
                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3"
                        >Password</label>
                        <div class="col-sm-12 col-md-7">
                            <input
                                v-bind:class="{'is-invalid': errors.password}"
                                type="password"
                                v-model="password"
                                class="form-control"
                                autocomplete="new-password"
                                placeholder="Set an account password."
                            />
                            <div class="invalid-feedback" v-if="errors.password">
                                <p>{{ errors.password[0] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label
                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3"
                        >Confirm Password</label>
                        <div class="col-sm-12 col-md-7">
                            <input
                                v-bind:class="{'is-invalid': errors.password_confirmation}"
                                type="password"
                                v-model="password_confirmation"
                                class="form-control"
                                placeholder="Confirm account password."
                                autocomplete="new-password"
                            />
                            <div class="invalid-feedback" v-if="errors.password_confirmation">
                                <p>{{ errors.password_confirmation[0] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button
                                v-bind:disabled="loading"
                                @click="addUser"
                                class="btn btn-danger"
                            >
                                <span v-if="loading">Adding</span>
                                <span v-else>Add</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            bank: "",
            bank_account: "",
            category: "",
            origin: "",
            errors: [],
            banks: [],
            categories: [],
            origins: [],
            message: "",
            loading: false
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            axios
                .all([
                    axios.get(this.$parent.MakeUrl("api/v1/master_data/bank")),
                    axios.get(
                        this.$parent.MakeUrl("api/v1/master_data/category")
                    ),
                    axios.get(this.$parent.MakeUrl("api/v1/master_data/origin"))
                ])
                .then(
                    axios.spread((bank, category, origin) => {
                        this.banks = bank.data;
                        this.categories = category.data;
                        this.origins = origin.data;
                    })
                )
                .catch(e => {});
        },
        addUser() {
            let _this = this;
            _this.errors = [];
            _this.message = "";
            _this.loading = true;
            axios
                .post(
                    this.$parent.MakeUrl(
                        "api/v1/users/proc/procurement/storeUser"
                    ),
                    {
                        name: this.name,
                        role: this.role,
                        email: this.email,
                        current_password: this.current_password,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                        bank_account: _this.bank_account,
                        bank: _this.bank,
                        category: _this.category,
                        origin: _this.origin
                    }
                )
                .then(res => {
                    _this.loading = false;
                    _this.resetForm();
                    _this.message =
                        "User account has been successfully created!";
                    window.location.href =
                        "/admin/procurement/user_procurement";
                })
                .catch(err => {
                    _this.errors = err.response.data.errors;
                    _this.loading = false;
                    console.log(err.response);
                });
        },
        resetForm() {
            this.name = "";
            this.email = "";
            this.password = "";
            this.bank = "";
            this.bank_account = "";
            this.origin = "";
            this.category = "";
            this.password_confirmation = "";
        }
    }
};
</script>
