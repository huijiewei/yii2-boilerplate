<template>
  <el-breadcrumb class="ag-breadcrumb">
    <el-breadcrumb-item :to="{ path: '/home' }">
      <i class="el-icon-s-home" />&nbsp;
      <span>管理后台</span>
    </el-breadcrumb-item>
    <template v-for="(breadcrumb, index) in breadcrumbs">
      <el-breadcrumb-item :key="index" :to="{ path: breadcrumb.path }">
        <bp-icon v-if="breadcrumb.icon" :type="breadcrumb.icon" />
        <span>{{ breadcrumb.title }}</span>
      </el-breadcrumb-item>
    </template>
  </el-breadcrumb>
</template>

<script>
export default {
  name: 'Breadcrumb',
  data() {
    return {
      breadcrumbs: [],
      documentTitle: '%s - ' + document.title
    }
  },
  watch: {
    $route() {
      this.updateBreadcrumbs()
    }
  },
  mounted() {
    this.updateBreadcrumbs()
  },
  methods: {
    updateBreadcrumbs() {
      const breadcrumbs = []

      this.$route.matched.forEach(route => {
        const breadcrumb = route.meta.breadcrumb

        if (breadcrumb) {
          breadcrumbs.push(breadcrumb)
        }
      })

      this.breadcrumbs = breadcrumbs

      const titles = []

      for (let i = breadcrumbs.length - 1; i >= 0; i--) {
        if (breadcrumbs[i].title) {
          titles.push(breadcrumbs[i].title)
        }
      }

      document.title = this.documentTitle.replace('%s', titles.join(' - '))
    }
  }
}
</script>

<style lang="scss">
.ag-breadcrumb {
  margin-bottom: 15px;

  .is-link {
    font-weight: normal;
  }
}
</style>
