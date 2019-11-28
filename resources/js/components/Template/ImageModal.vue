<template>
    <a href='#' class="badge badge-info" @click="showFile()">
        {{ fileName }}
    </a>
</template>

<script>
    export default {
        props: ['fileUrl', 'fileName'],
        name: "ImageModal",
        methods: {
            showFile() {
                Vue.swal({
                    title: this.fileName,
                    imageUrl: this.fileUrl,
                    imageAlt: this.fileName,
                })
            }
        }
    }
</script>

<style scoped>

</style>
