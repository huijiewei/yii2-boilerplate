<template>
  <el-menu :router="true" :default-active="$route.path" class="bp-menu">
    <template v-for="(menu, index) in menus">
      <sider-menu-item v-if="!menu.children" :menu="menu" :key="'m' + 1 + index"></sider-menu-item>
      <sider-menu-sub v-else :menu="menu" :key="'m' + 1 + index" :depth="1" :index="index"></sider-menu-sub>
    </template>
  </el-menu>
</template>

<script>
  import SiderMenuSub from './SiderMenuSub'
  import SiderMenuItem from './SiderMenuItem'

  export default {
    name: 'SiderMenu',
    components: {
      SiderMenuSub,
      SiderMenuItem
    },
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
    .el-submenu {
      .anticon {
        font-size: 16px;
        vertical-align: middle;
        text-align: center;
        width: 22px;
      }
    }

    .el-menu-item,
    .el-submenu__title {
      line-height: 50px;
      height: 50px;
    }

    .el-submenu .el-menu-item {
      line-height: 39px;
      height: 39px;
    }

    .el-submenu__icon-arrow {
      margin-top: -4px;
    }
  }
</style>

