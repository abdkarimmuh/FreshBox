<template>
    <div class="col-md-12">
        <table width="100%">
            <thead>
            <tr style="border-bottom: 1px solid black; border-top: 1px solid black">
                <th class="text-right">No</th>
                <th class="text-right" v-for="(col, index) in columns">
                    {{ col.title }}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr style="border-bottom: 0px" v-for="(item, index) in data" :key="index">
                <td class="text-right">{{ index + 1 }}</td>
                <td class="text-right" v-for="(col,index) in columns">
                    <div v-if="col.type === 'text'">
                        {{ item[col.field]}}
                    </div>
                    <div v-else-if="col.type === 'currency'">
                        {{ item[col.field] | toIDR }}
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['columns', 'data']
    }
</script>

<style scoped>

</style>
