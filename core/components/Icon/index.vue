<template>
  <i class="ag-icon">
    <svg
      viewBox="0 0 1024 1024"
      version="1.1"
      xmlns="http://www.w3.org/2000/svg"
      fill="currentColor"
      v-html="path"
    />
  </i>
</template>

<script>
export default {
  name: 'AgIcon',
  props: {
    path: {
      type: String,
      required: true,
    },
  },
}
</script>
<style lang="scss">
.ag-icon {
  text-rendering: optimizeLegibility;
  -webkit-font-smoothing: antialiased;
  line-height: 0;
  font-style: normal;
  display: inline-block;
  color: inherit;
  text-align: center;
  margin-right: 3px;

  svg {
    display: inline-block;
    line-height: 1;
    vertical-align: -0.125em;
    width: 1em;
    height: 1em;
  }
}
</style>
