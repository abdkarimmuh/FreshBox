<template>
    <div :class="'col-md-' + col">
        <div class="form-group">
            <label>
                <b>{{ label }}</b>
                <span style="color: red;" v-if="mandatory">*</span>
            </label>
            <div>
                <model-list-select
                    :slot="bindclass"
                    :list="data"
                    v-model="model"
                    v-on:input="oninput"
                    :option-value="optionValue"
                    :option-text="optionText"
                    :placeholder="placeholder"
                ></model-list-select>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    import {ModelListSelect} from "vue-search-select";

    export default {
        name: "StislaSearchSelect",
        props: ['label', 'data', 'model', 'oninput', 'optionValue', 'optionText', 'placeholder', 'errors', 'bindclass','col','mandatory'],
        components: {
            ModelListSelect
        }
    }
</script>

<style scoped>

</style>
