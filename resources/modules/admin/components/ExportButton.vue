<template>
  <el-button
    :type="type"
    :size="size"
    :loading="isLoading"
    @click="handleClick">
    <slot></slot>
  </el-button>
</template>

<script>
  export default {
    name: 'ExportButton',
    props: ['api', 'type', 'size', 'loading'],
    data() {
      return {
        isLoading: false
      }
    },
    mounted() {
      this.updateLoading()
    },
    watch: {
      'loading': 'updateLoading'
    },
    methods: {
      updateLoading() {
        this.isLoading = this.loading
      },
      handleClick: async function() {
        this.isLoading = true

        await this.$http.download(
          'GET',
          this.api,
          Object.assign({ page: null }, this.$route.query))

        this.isLoading = false
      }
    }
  }
</script>
