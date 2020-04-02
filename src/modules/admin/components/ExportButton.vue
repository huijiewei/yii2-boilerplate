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
import flatry from '@core/utils/flatry'

export default {
  name: 'ExportButton',
  // eslint-disable-next-line vue/require-prop-types
  props: ['api', 'type', 'size', 'disabled'],
  data() {
    return {
      loading: false,
      loadingText: '',
    }
  },
  methods: {
    async handleClick() {
      this.loading = true
      this.loadingText = '正在导出 Excel'

      const { data } = await flatry(
        this.$http.download(
          'GET',
          this.api,
          Object.assign({}, this.$route.query, {
            page: null,
            size: null,
          })
        )
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
  },
}
</script>
