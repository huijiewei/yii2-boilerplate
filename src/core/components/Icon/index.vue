<template>
  <span class="ag-icon">
    <svg
      viewBox="0 0 1024 1024"
      version="1.1"
      xmlns="http://www.w3.org/2000/svg"
      :width="width"
      :height="height"
      v-html="path"
    />
  </span>
</template>

<script>
export default {
  name: 'AgIcon',
  props: {
    path: {
      type: String,
      required: true
    },
    width: {
      type: [Number, String],
      default: 16
    },
    height: {
      type: [Number, String],
      default: 16
    }
  }
}
</script>
<style lang="scss">
.ag-icon {
  display: inline-block;
  vertical-align: middle;
  line-height: 1;

  svg {
    vertical-align: middle;
  }
}
</style>
