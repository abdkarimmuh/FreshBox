<template>
    <div class="row">
        <div class="col-12">
            <div class="card col-12">
                <div class="card-header">
                    <h4 class="text-danger">{{ title }}</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "StislaCreateTemplate",
        props: ['title']
    }
</script>

<style scoped>

</style>
