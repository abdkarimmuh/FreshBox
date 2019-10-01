<template>
    <a @click="confirm"
       class="badge badge-warning"
       title="Confirm">
        Confirm
    </a>
</template>

<script>

    export default {
        data() {
            return {}
        },
        methods: {
            async confirm() {
                const {value: formValues} = await Vue.swal({
                    title: 'Multiple inputs',
                    html: '<input type="text" class="form-control datepicker">',
                    focusConfirm: false,
                    preConfirm: () => {
                        return [
                            document.getElementById('swal-input1').value,
                            document.getElementById('swal-input2').value
                        ]
                    }
                })

                if (formValues) {
                    Swal.fire(JSON.stringify(formValues))
                }
            }
        }
    }
</script>

<style scoped>

</style>
