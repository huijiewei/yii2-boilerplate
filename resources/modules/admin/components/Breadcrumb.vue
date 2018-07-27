<template>
  <el-breadcrumb class="bp-breadcrumb">
    <el-breadcrumb-item :to="{path:'/home'}">
      <bp-icon type="home"></bp-icon>
      <span>管理后台</span>
    </el-breadcrumb-item>
    <template v-for="(breadcrumb, index) in breadcrumbs">
      <el-breadcrumb-item :to="{ path: breadcrumb.path }" :key="index">
        <bp-icon v-if="breadcrumb.icon" :type="breadcrumb.icon"></bp-icon>
        <span>{{ breadcrumb.title }}</span>
      </el-breadcrumb-item>
    </template>
  </el-breadcrumb>
</template>

<script>
  import BpIcon from '@core/components/Icon/index'

  export default {
    name: 'Breadcrumb',
    components: { BpIcon },
    data() {
      return {
        breadcrumbs: [],
        documentTitle: '%s - ' + document.title
      }
    },
    mounted() {
      this.updateBreadcrumbs()
    },
    methods: {
      updateBreadcrumbs() {
        const breadcrumbs = []

        this.$route.matched.forEach((route) => {
          const breadcrumb = route.meta.breadcrumb

          if (breadcrumb) {
            breadcrumbs.push(breadcrumb)
          }
        })

        this.breadcrumbs = breadcrumbs

        this.updatePageTitle()
      },
      updatePageTitle() {
        const breadcrumbs = this.breadcrumbs
        const titles = []

        for (let i = breadcrumbs.length - 1; i >= 0; i--) {
          if (breadcrumbs[i].title) {
            titles.push(breadcrumbs[i].title)
          }
        }

        document.title = this.documentTitle.replace('%s', titles.join(' - '))
      }
    },
    watch: {
      $route() {
        this.updateBreadcrumbs()
      }
    }
  }
</script>

<style lang="scss">
  .bp-breadcrumb {
    margin-bottom: 15px;

    .is-link {
      font-weight: normal;
    }
  }
</style>
