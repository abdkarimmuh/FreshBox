<template>
    <div class="row" v-if="$parent.userCan('manage-users')">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Category</h4>
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
    export default {
        data() {
            return {
                url: "/api/master/category",
                perPage: ['10', '25', '50'],
                columns: [

                    {
                        label: 'ID',
                        name: 'id',
                        filterable: true,
                    },
                    {
                        label: 'Name',
                        name: 'name',
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
        }
    }
</script>
