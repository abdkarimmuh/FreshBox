<template>
    <div class="row" v-if="$parent.userCan('manage-users')">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Sales Order</h4>
                    <div class="card-header-action">
                        <router-link v-if="$parent.userCan('create-users')" :to="{ name: 'AddSalesOrder'}"
                           class="btn btn-primary">Add <i class="fas fa-plus"></i></router-link>
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
    import ViewButton from "../../Button/ViewButton";
    import Badge from "../../Button/Badge";

    export default {
        data() {
            return {
                url: "/api/marketing/sales_order",
                perPage: ['5','10', '25', '50'],
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
                        label: 'Sales Order NO',
                        name: 'sales_order_no',
                        filterable: true,
                    },
                    {
                        label: 'Customer',
                        name: 'customer_name',
                        filterable: true,
                    },
                    {
                        label: 'Source Order',
                        name: 'source_order_name',
                        filterable: false,
                    },
                    {
                        label: 'Fulfillment Date',
                        name: 'fulfillment_date',
                        filterable: true,
                    },
                    {
                        label: 'Remarks',
                        name: 'remarks',
                        filterable: true,
                    },
                    {
                        label: 'Status',
                        filterable: true,
                        component: Badge,

                    },
                    {
                        label: 'Created At',
                        name: 'created_at',
                        filterable: true,
                    },
                    {
                        label: 'Created By',
                        name: 'created_by_name',
                        filterable: true,
                    },
                    {
                        label: 'Updated At',
                        name: 'updated_at',
                        filterable: true,
                    },
                    {
                        label: 'Updated By',
                        name: 'updated_by_name',
                        filterable: true,
                    },

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
