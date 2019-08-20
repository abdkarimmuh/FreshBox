<template>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-primary" v-if="message">
                {{ message }}
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Sales Order Details</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Sales Order No<span style="color: red;">*</span></label>
                                <div>
                                    <input v-bind:class="{'is-invalid': errors.email}" type="text"
                                           v-model="sales_order_no"
                                           class="form-control" placeholder="Sales Order No.">
                                    <div class="invalid-feedback" v-if="errors.email">
                                        <p>{{ errors.email[0] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Customer<span style="color: red;">*</span></label>
                                <div>
                                    <select class="form-control" v-model="role"
                                            v-bind:class="{'is-invalid': errors.role}">
                                        <option v-for="role in roles" v-bind:value="role.id">{{ role.name }}
                                        </option>
                                    </select>
                                    <div class="invalid-feedback" v-if="errors.role">
                                        <p>{{ errors.role[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Default Input Text</label>
                                <div>
                                    <input v-bind:class="{'is-invalid': errors.email}" type="text" v-model="email"
                                           class="form-control" placeholder="Email address (should be unique).">
                                    <div class="invalid-feedback" v-if="errors.email">
                                        <p>{{ errors.email[0] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Default Input Text</label>
                                <div>
                                    <input v-bind:class="{'is-invalid': errors.email}" type="text" v-model="email"
                                           class="form-control" placeholder="Email address (should be unique).">
                                    <div class="invalid-feedback" v-if="errors.email">
                                        <p>{{ errors.email[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                <div class="card-body">-->
                <!--                    <div class="form-group row mb-4">-->
                <!--                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>-->
                <!--                        <div class="col-sm-12 col-md-7">-->
                <!--                            <input v-bind:class="{'is-invalid': errors.email}" type="text" v-model="email"-->
                <!--                                   class="form-control" placeholder="Email address (should be unique).">-->
                <!--                            <div class="invalid-feedback" v-if="errors.email">-->
                <!--                                <p>{{ errors.email[0] }}</p>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="form-group row mb-4">-->
                <!--                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Role</label>-->
                <!--                        <div class="col-sm-12 col-md-7">-->
                <!--                            <select class="form-control" v-model="role" v-bind:class="{'is-invalid': errors.role}">-->
                <!--                                <option v-for="role in roles" v-bind:value="role.id">{{ role.name }}</option>-->
                <!--                            </select>-->
                <!--                            <div class="invalid-feedback" v-if="errors.role">-->
                <!--                                <p>{{ errors.role[0] }}</p>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="form-group row mb-4">-->
                <!--                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>-->
                <!--                        <div class="col-sm-12 col-md-7">-->
                <!--                            <input v-bind:class="{'is-invalid': errors.password}" type="password" v-model="password"-->
                <!--                                   class="form-control" autocomplete="new-password"-->
                <!--                                   placeholder="Set an account password.">-->
                <!--                            <div class="invalid-feedback" v-if="errors.password">-->
                <!--                                <p>{{ errors.password[0] }}</p>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="form-group row mb-4">-->
                <!--                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Confirm Password</label>-->
                <!--                        <div class="col-sm-12 col-md-7">-->
                <!--                            <input v-bind:class="{'is-invalid': errors.password_confirmation}" type="password"-->
                <!--                                   v-model="password_confirmation" class="form-control"-->
                <!--                                   placeholder="Confirm account password." autocomplete="new-password">-->
                <!--                            <div class="invalid-feedback" v-if="errors.password_confirmation">-->
                <!--                                <p>{{ errors.password_confirmation[0] }}</p>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="form-group row mb-4">-->
                <!--                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>-->
                <!--                        <div class="col-sm-12 col-md-7">-->
                <!--                            <button v-bind:disabled="loading" @click="addUser" class="btn btn-primary"><span-->
                <!--                                v-if="loading">Adding</span><span v-else>Add</span></button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                sales_order_no: '',
                password: '',
                password_confirmation: '',
                errors: [],
                role: '',
                roles: '',
                message: '',
                loading: false
            }
        },
        mounted() {
            this.getRoles();
        },
        methods: {
            getRoles() {
                axios.get(this.$parent.MakeUrl('api/users/roles')).then((res) => {
                    this.roles = res.data;
                }).catch((err) => {

                });
            },
            addUser() {
                let _this = this;
                _this.errors = [];
                _this.message = '';
                _this.loading = true;
                axios.post(this.$parent.MakeUrl('admin/users'), {
                    'name': this.name,
                    'role': this.role,
                    'email': this.email,
                    'current_password': this.current_password,
                    'password': this.password,
                    'password_confirmation': this.password_confirmation
                }).then((res) => {
                    _this.loading = false;
                    _this.resetForm();
                    _this.message = 'User account has been successfully created!';
                }).catch((err) => {
                    _this.errors = err.response.data.errors;
                    _this.loading = false;
                });
            },
            resetForm() {
                this.name = '';
                this.email = '';
                this.password = '';
                this.role = '';
                this.password_confirmation = '';
            }
        }
    }
</script>
