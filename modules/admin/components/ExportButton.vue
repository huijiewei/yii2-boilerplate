<template>
  <el-button
    v-loading.fullscreen="loading"
    :type="type"
    :size="size"
    :disabled="disabled"
    :element-loading-text="loadingText"
    element-loading-spinner="el-icon-loading"
    @click="handleClick"
  >
    <slot />
  </el-button>
</template>

<script>
export default {
  name: 'ExportButton',
  // eslint-disable-next-line vue/require-prop-types
  props: ['api', 'type', 'size', 'disabled', 'confirm'],
  data() {
    return {
      loading: false,
      loadingText: '',
    }
  },
  methods: {
    async export() {
      this.loading = true
      this.loadingText = '正在导出 Excel'

      const { data } = await this.$http.download(
        'GET',
        this.api,
        Object.assign({}, this.$route.query, {
          page: null,
          size: null,
        })
      )

      if (data === false) {
        this.$message({
          type: 'warning',
          message: '下载文件失败',
          duration: 1500,
        })
      }

      this.loading = false
    },
    handleClick() {
      if (this.confirm && this.confirm.length > 0) {
        this.$confirm(this.confirm, '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning',
        }).then(() => {
          this.export()
        })
      } else {
        this.export()
      }
    },
  },
}
</script>
