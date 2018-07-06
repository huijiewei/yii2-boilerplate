<template>
  <el-menu :collapse-transition="false" :router="true" :default-active="$route.path" :collapse="isCollapsed">
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
    props: ['isCollapsed'],
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
  body {
    .el-menu {
      border-right: none;
    }

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
      line-height: 50px;
      height: 50px;
    }

    .el-submenu__icon-arrow {
      margin-top: -4px;
    }

    .el-menu--collapse {
      width: 100%;
    }
  }
</style>

