<template>
    <div>
        <div class="col-md-12">
            <div class="pull-right text-right">
                <h4><b class="text-danger">{{ info.title }}<span
                    class="pull-right">#{{ data[info.no] }}</span></b>
                </h4>
            </div>
            <table width="80%">
                <tbody>
                <tr v-for="(item, index) in header_info">
                    <div v-if="!item.page_break">
                        <td width="150px" class="text-right"><b>{{ item.title }}</b></td>
                        <td width="15px">&nbsp;:</td>
                        <td width="40%">{{ data[item.field] }}</td>
                        <td width="40%"></td>
                    </div>
                    <div v-else-if="item.page_break">
                        <td height="15px"></td>
                    </div>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['header_info', 'data', 'info'],
        data() {
            return {}
        },
    }
</script>

<style scoped>

</style>
