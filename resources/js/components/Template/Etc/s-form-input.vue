<template>
  <div v-bind:class="'col-md-'+ col">
    <div class="form-group">
      <label><b>{{ title }}</b><span style="color: red;" v-if="mandatory">*</span></label>
      <div>
        <input
          v-bind:type="type"
          class="form-control"
          v-model="model"
          :disabled="disabled"
        >
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ['model', 'title', 'disabled', 'type', 'col', 'mandatory'],
  data () {
    return {

    }
  }
}
</script>
