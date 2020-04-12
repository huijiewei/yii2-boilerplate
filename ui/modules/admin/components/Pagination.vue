<template>
  <div v-if="pages" class="ag-pages">
    <el-pagination
      :background="true"
      :current-page.sync="pages.currentPage"
      :page-sizes="[20, 50, 100, 200]"
      :page-size="pages.perPage"
      layout="total, prev, pager, next, sizes, jumper"
      :total="pages.totalCount"
      @current-change="handleCurrentChange"
      @size-change="handleSizeChange"
    />
  </div>
</template>

<script>
export default {
  name: 'Pagination',

  props: {
    pages: {
      type: Object,
      default: () => {
        return null
      },
    },
  },
  methods: {
    handleSizeChange(size) {
      this.$router.push({
        path: this.$route.fullPath,
        query: { page: 1, size: size },
      })
    },
    handleCurrentChange(page) {
      this.$router.push({
        path: this.$route.fullPath,
        query: { page: page },
      })
    },
  },
}
</script>
<style lang="scss">
.ag-pages {
  margin-top: 20px;
  text-align: right;
}
</style>
