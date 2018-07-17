<template>
  <el-breadcrumb class="bp-breadcrumb">
    <el-breadcrumb-item :to="{ name: 'site-index' }">
      <bp-icon type="home"></bp-icon>
      管理后台
    </el-breadcrumb-item>
    <template v-for="(route, index) in $route.matched.slice()">
      <el-breadcrumb-item :to="route" :key="index">
        {{ route.name }}
      </el-breadcrumb-item>
    </template>
  </el-breadcrumb>
</template>

<script>
  import BpIcon from '@core/components/Icon/index'

  export default {
    name: 'Breadcrumb',
    components: { BpIcon },
    created() {
      this.getBreadcrumb()
    },
    data() {
      return {
        title: '',
        breadcrumbs: []
      }
    },
    methods: {
      getBreadcrumb() {
        this.brumblist = this.$route.matched

        this.$route.matched.forEach((item) => {

          item.meta.title === '首页' ?
            item.path = '/' :
            this.$route.path === item.path ? this.title = item.meta.title : ''
        })
      }
    },
    watch: {
      $route() {
        this.getBreadcrumb()
      }
    }
  }
</script>

<style lang="scss">
  .bp-main {
    padding: 16px 20px;

    .bp-breadcrumb {
      margin-bottom: 15px;
      font-size: 13px;

      .is-link {
        font-weight: normal;
      }

      .anticon {
        font-size: 12px;
      }
    }
  }
</style>
