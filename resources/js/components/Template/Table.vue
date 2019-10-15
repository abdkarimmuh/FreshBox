<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div v-bind:class="{ 'col-lg-7': config.daterange, 'col-lg-8' : config.action}">
                        <div class="row">
                            <h4 class="text-danger">{{ config.title }}</h4>
                            <router-link :to="{ name: config.route_create }" class="btn btn-danger ml-2"
                                         v-if="config.route_create">Add
                                <i class="fas fa-plus"></i></router-link>
                            <a @click="toExcel('vuetable', 'Test')" class="btn btn-danger ml-2"
                               style="color: white" v-if="config.export_excel">Export Excel</a>
                            <a class="btn btn-info ml-2" style="color: white" @click="print()"
                               v-if="config.route_multiple_print && selected != 0">Print
                                <i class="fas fa-print"></i></a>
                            <a class="btn btn-primary ml-2" @click="printRekap"
                               style="color: white" v-if="config.route_print_rekap && selected != 0">Print Rekap <i
                                class="fas fa-print"></i></a>
                        </div>
                    </div>
                    <div class="card-header-action ml-0 mt-3 mb-3">
                        <div class="input-group" v-if="config.daterange">
                            <date-picker
                                v-model="params.start"
                                lang="en"
                                type="date"
                                placeholder="Start Date"
                                valueType="format"
                                format="YYYY-MM-DD"
                            ></date-picker>
                            <date-picker
                                v-model="params.end"
                                lang="en"
                                type="date"
                                valueType="format"
                                placeholder="End Date"
                                format="YYYY-MM-DD"
                            ></date-picker>
                            <input type="text" class="form-control ml-2" placeholder="Search" v-model="params.query">
                            <div class="input-group-btn ml-1">
                                <button class="btn btn-danger" v-on:click="search" :disabled="!loading">
                                    <i class="fas fa-search" v-if="loading"></i>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                          aria-hidden="true" v-if="!loading"></span>
                                    <span class="sr-only" v-if="!loading">Loading...</span>
                                </button>
                            </div>
                        </div>
                        <div class="input-group" v-else>
                            <input type="text" class="form-control ml-2" placeholder="Start"
                                   v-model="params.start">
                            <input type="text" class="form-control ml-2" placeholder="End" v-model="params.end">
                            <input type="text" class="form-control ml-2" placeholder="Search" v-model="params.query">
                            <div class="input-group-btn ml-1">
                                <button class="btn btn-danger" v-on:click="search" :disabled="!loading">
                                    <i class="fas fa-search" v-if="loading"></i>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                          aria-hidden="true" v-if="!loading"></span>
                                    <span class="sr-only" v-if="!loading">Loading...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label ml-5">Show</label>
                <div class="ml-3">
                    <label>
                        <select class="form-control" v-model="params.perPage" v-on:change="getData">
                            <option v-for="(perPage, index) in perPages" :value="perPage">{{ perPage }}</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" v-if="loading">
                    <table class="table table-bordered" v-if="data.length" id="vuetable">
                        <tbody>
                        <tr>
                            <th v-if="config.action">
                                <div class="custom-checkbox custom-control">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-all"
                                           v-model="selectAll">
                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                </div>
                            </th>
                            <th v-if="config.action">Action</th>
                            <th v-for="column in columns"> {{ column.title }}</th>
                        </tr>
                        <tr v-for="(item, index) in data">
                            <!--CheckBox-->
                            <td v-if="config.action">
                                <div class="custom-checkbox custom-control">
                                    <input type="checkbox" class="custom-control-input" :value="item.id"
                                           v-model="selected" :id="'checkbox-'+ index">
                                    <label :for="'checkbox-'+index" class="custom-control-label">&nbsp;</label>
                                </div>

                            </td>
                            <!--Button-->

                            <td v-if="config.action">
                                <router-link v-if="config.route_view" class="badge badge-primary"
                                             :to="{ name: config.route_view , params: { id: item.id }}">View
                                </router-link>

                                <router-link v-if="config.route_edit && item.status === 1 && item.is_printed === 0"
                                             class="badge badge-warning"
                                             :to="{ name: config.route_edit , params: { id: item.id }}">Edit
                                </router-link>
                            </td>
                            <td v-for="column in columns">
                                <span v-html="item[column.field]" v-if="column.type === 'html'"></span>
                                <a v-bind:href="item[column.field_url]" v-else-if="column.type === 'link'">{{
                                    item[column.field] }}</a>
                                <p v-else-if="column.type === 'price'">
                                    {{ item[column.field] | toIDR }}
                                </p>
                                <p v-else>
                                    {{ item[column.field] }}
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-if="!data.length" class="text-center p-3 text-muted">
                        <h5>No Results</h5>
                        <p>Looks like you have not added any users yet!</p>
                    </div>
                </div>
                <div class="text-center p-4 text-muted" v-else>
                    <h5>Loading</h5>
                    <p class="beep-sidebar">Please wait, data is being loaded...</p>
                    <div class="spinner-grow text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>

            <nav class="row" v-if="pagination">
                <div class="col-md-6 text-left">
            <span>
                &nbsp;Showing&nbsp;
                {{ pagination.from }}
                &nbsp;to&nbsp;
                {{pagination.to}}
                &nbsp;of&nbsp;
                {{pagination.total}}
                &nbsp;entries&nbsp;
            </span>
                </div>
                <div class="col-md-6 text-right">
                    <button
                        v-if="pagination.prev"
                        :class="buttonClasses"
                        @click="changePage(pagination.current_page - 1)">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        &nbsp;Prev
                    </button>
                    <button
                        v-if="pagination.next"
                        :class="buttonClasses"
                        @click="changePage(pagination.current_page + 1)">
                        Next&nbsp;
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </button>
                </div>
            </nav>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['columns', 'config'],
        data() {
            return {
                user: {},
                perPages: ['5', '10', '25', '50'],
                buttonClasses: 'btn btn-primary',
                selected: [0],
                data: [],
                loading: false,
                pagination: {
                    current_page: 1,
                    first: null,
                    prev: null,
                    next: null,
                    last_page: null,
                    total: 0,
                },
                params: {
                    query: null,
                    page: 1,
                    start: null,
                    end: null,
                    perPage: 5,
                },
            }
        },
        async mounted() {
            await this.getData();
            this.user = AuthUser;
        },
        methods: {
            async search() {
                this.loading = false;
                this.pagination = null;
                try {
                    await this.getData();
                    this.loading = true;
                } catch (e) {
                    console.log(e);
                }
            },
            async getData() {
                await axios.get(this.config.base_url, {params: this.params}).then(res => {
                    this.data = res.data.data;

                    this.pagination = {
                        first: res.data.links.first,
                        last: res.data.links.last,
                        prev: res.data.links.prev,
                        next: res.data.links.next,
                        from: res.data.meta.from,
                        to: res.data.meta.to,
                        total: res.data.meta.total,
                        current_page: res.data.meta.current_page,
                        last_page: res.data.meta.last_page,
                        path: res.data.meta.path,

                    };
                    this.loading = true;

                }).catch(e => {
                    if (e.response.status === 500) {
                        this.getData();
                    }
                    console.log(e.response)
                });
            },
            changePage(page) {
                if (page > this.pagination.last_page) {
                    page = this.pagination.last_page;
                }
                this.params.page = page;
                this.getData();
            },
            print() {
                this.$router.push({name: this.config.route_multiple_print, query: {id: this.selected}})
            },
            printRekap() {
                const payload = {
                    id: this.selected,
                    userId: this.user.id,
                };
                axios.get(BaseUrl('api/v1/finance/invoice_order/generateRecapInvoice'), {params: payload})
                    .then(res => {
                        if (res.data.status === true) {
                            Vue.swal({
                                type: "success",
                                title: "Success!",
                                text: "Berhasil Membuat Rekap Invoice!"
                            }).then(next => {
                                this.$router.push({
                                    name: this.config.route_print_rekap,
                                    params: {id: res.data.invoice_recap_id}
                                })
                            });
                        } else {
                            Vue.swal({
                                type: "error",
                                title: "Danger!",
                                text: "Customer Harus Sama!"
                            });
                        }
                        console.log(res);
                    }).catch(e => {

                });
            },
            toExcel(table, name) {
                var uri = 'data:application/vnd.ms-excel;base64,',
                    template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                    , base64 = function (s) {
                        return window.btoa(unescape(encodeURIComponent(s)));
                    }, format = function (s, c) {
                        return s.replace(/{(\w+)}/g, function (m, p) {
                            return c[p];
                        });
                    };
                if (!table.nodeType) table = document.getElementById(table);
                var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML};
                window.location.href = uri + base64(format(template, ctx));
            }
        },
        computed: {
            selectAll: {
                get: function () {
                    return this.data ? this.selected.length === this.data.length : false;
                },
                set: function (value) {
                    let selected = [];
                    if (value) {
                        this.data.forEach(function (data) {
                            selected.push(data.id);
                        });
                    }
                    this.selected = selected;
                }
            }
        }
    }
</script>
