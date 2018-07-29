<template>
  <el-button
    :type="type"
    :size="size"
    :loading="loading"
    @click="handleClick">
    <slot></slot>
  </el-button>
</template>

<script>
  export default {
    name: 'ExportButton',
    props: ['api', 'type', 'size', 'loading'],
    methods: {
      handleClick() {
        this.$http.download(
          'GET',
          this.api,
          Object.assign({ page: null }, this.$route.query))
      }
    }
  }
</script>
