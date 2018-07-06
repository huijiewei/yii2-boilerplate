<template>
  <el-menu :router="true" :default-active="$route.path" class="bp-menu">
    <sider-menu :menus="menus" :depth="1"></sider-menu>
  </el-menu>
</template>

<script>
  import SiderMenu from '@admin/components/SiderMenu'

  export default {
    name: 'Sider',
    components: { SiderMenu },
    data() {
      return {
        menus: []
      }
    },
    mounted() {
      this.$http.get('site/menus').then(response => {
        this.menus = response.data
      })
    }
  }
</script>
<style lang="scss">
  .bp-menu {
    .el-menu-item,
    .el-submenu__title {
      line-height: 50px;
      height: 50px;
    }

    .el-submenu .el-menu-item {
      line-height: 39px;
      height: 39px;
    }
  }
</style>
