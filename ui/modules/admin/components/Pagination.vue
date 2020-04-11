<template>
  <div v-if="pages" class="ag-pages">
    <el-pagination
      :background="true"
      :current-page="pages.currentPage"
      :page-size="pages.perPage"
      layout="total, prev, pager, next, jumper"
      :total="pages.totalCount"
      @current-change="handleCurrentChange"
    />
  </div>
</template>

<script>
export default {
  name: 'Pagination',

  props: {
    pages: {
      type: Array,
      default: () => {
        return null
      },
    },
  },
  methods: {
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
