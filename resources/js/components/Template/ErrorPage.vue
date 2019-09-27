<template>
    <div class="container mt-5">
        <div class="page-error">
            <div class="page-inner">
                <h1>{{ error.code }}</h1>
                <div class="page-description">
                    {{ error.description }}.
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['error'],
    }
</script>

<style scoped>

</style>
