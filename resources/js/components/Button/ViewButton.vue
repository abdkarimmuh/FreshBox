<template>
    <div>
        <router-link :to="{ name: data.view_route  ,  params: { id: data.id }}" class="badge badge-primary"
                     title="View">
            View
        </router-link>

        <router-link :to="{ name: data.edit_route  ,  params: { id: data.id }}" class="badge badge-warning"
                     title="Edit">
            Edit
        </router-link>
    </div>
</template>

<script>
    export default {
        props: {
            data: {},
            name: {},
            label: {},
            click: {},
            meta: {},
            classes: {},
        }
    }
</script>

<style scoped>

</style>
