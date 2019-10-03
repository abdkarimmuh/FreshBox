<template>
    <div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="text-left">
                    <table>
                        <tbody>
                        <tr>
                            <td><b>{{ info.nama_pt }}</b></td>
                        </tr>
                        <tr>
                            <td><b>{{ info.alamat }}</b></td>
                        </tr>
                        <tr>
                            <td><b>{{ info.daerah }}</b></td>
                        </tr>
                        <tr>
                            <td><b>{{ info.contact }}</b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-right">
                    <img v-bind:src="logo">
                </div>
            </div>
        </div>
        <hr>
    </div>
</template>

<script>
    export default {
        props: ['logo'],
        data() {
            return {
                info: {
                    nama_pt: 'PT BERKAH TANI SEJAHTERA',
                    alamat: 'Rukan Greenlake Ruko Greatwall B60 - B61',
                    daerah: 'Cipondoh - Tangerang 15147',
                    contact: 'Telp : 021-54315198'
                },
            }
        }
    }
</script>
