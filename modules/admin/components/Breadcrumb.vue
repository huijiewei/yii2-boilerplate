<template>
  <el-breadcrumb class="ag-breadcrumb">
    <el-breadcrumb-item :to="{ path: '/home' }">
      <i class="el-icon-s-home" />&nbsp;
      <span>管理后台</span>
    </el-breadcrumb-item>
    <el-breadcrumb-item
      v-for="(breadcrumb, index) in breadcrumbs"
      :key="index"
      :to="{ path: breadcrumb.path }"
    >
      <bp-icon v-if="breadcrumb.icon" :type="breadcrumb.icon" />
      <span>{{ breadcrumb.title }}</span>
    </el-breadcrumb-item>
  </el-breadcrumb>
</template>

<script>
export default {
  name: 'Breadcrumb',
  data() {
    return {
      breadcrumbs: [],
      documentTitle: '%s - ' + '管理后台',
    }
  },
  watch: {
    $route() {
      this.updateBreadcrumbs()
    },
  },
  mounted() {
    this.updateBreadcrumbs()
  },
  methods: {
    updateBreadcrumbs() {
      const title = this.$route.meta.title

      this.breadcrumbs = [{ title: title }]

      document.title = this.documentTitle.replace('%s', title)
    },
  },
}
</script>

<style lang="less">
.ag-breadcrumb {
  margin-bottom: 15px;

  .is-link {
    font-weight: normal;
  }
}
</style>
