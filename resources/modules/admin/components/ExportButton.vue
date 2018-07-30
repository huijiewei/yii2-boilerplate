<template>
  <el-button
    :type="type"
    :size="size"
    :disabled="disabled"
    :element-loading-text="loadingText"
    element-loading-spinner="el-icon-loading"
    v-loading.fullscreen.lock="loading"
    @click="handleClick">
    <slot></slot>
  </el-button>
</template>

<script>
  import flatry from '@admin/utils/flatry'

  export default {
    name: 'ExportButton',
    props: ['api', 'type', 'size', 'disabled'],
    data() {
      return {
        loading: false,
        loadingText: ''
      }
    },
    methods: {
      handleClick: async function() {
        this.loading = true
        this.loadingText = '正在导出 Excel'

        const { data } = await flatry(this.$http.download(
          'GET',
          this.api,
          Object.assign({}, this.$route.query, { page: null })))

        if (data === false) {
          this.$message({
            type: 'warning',
            message: '下载文件失败',
            duration: 1500
          })
        }

        this.loading = false
      }
    }
  }
</script>
