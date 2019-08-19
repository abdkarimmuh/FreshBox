<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Users</h4>
                    <div class="card-header-action">
                        <a v-if="$parent.userCan('create-users')" v-bind:href="$parent.MakeUrl('admin/users/create')"
                           class="btn btn-primary">Add <i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <data-table
                        :url="url"
                        :columns="columns"
                        :per-page="perPage"
                        :pagination="pagination">
                    </data-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ViewButton from "./Button/ViewButton";

    export default {
        data() {
            return {
                url: "/api/data",
                perPage: ['10', '25', '50'],
                columns: [
                    {
                        label: 'Action',
                        filterable: false,
                        component: ViewButton,
                        event: "click",
                        handler: this.alertMe,
                        meta: {
                            'foo': 'bar',
                        }
                    },
                    {
                        label: 'ID',
                        name: 'id_penjaminan',
                        filterable: true,
                    },
                    {
                        label: 'thn_ijp',
                        name: 'thn_ijp',
                        filterable: true,
                    },
                    {
                        label: 'ijp',
                        name: 'ijp',
                        filterable: true,
                    },
                    {
                        label: 'tgl_produksi',
                        name: 'tgl_produksi',
                        filterable: true,
                    }
                ],
                pagination: {
                    limit: 1,
                    align: "right",
                    size: "small"
                },
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        components: {
            ViewButton,
        },
        methods: {
            alertMe(data) {
                alert("You have clicked ID: " + data.id);
            }
        },
    }
</script>
