<template>
  <el-menu :show-timeout="200" :hide-timeout="200" :collapse-transition="false" :router="true"
           :default-active="$route.path"
           :collapse="isCollapsed">
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
    created() {
      this.$http.get('site/menus').then(response => {
        this.menus = response.data
      }).catch(() => {
      })
    }
  }
</script>
<style lang="scss">
  .bp {
    .el-menu {
      border-right: none;
    }

    .el-menu-item,
    .el-submenu {
      .anticon {
        font-size: 15px;
        vertical-align: middle;
        text-align: center;
        width: 22px;
      }
    }

    .el-menu-item,
    .el-submenu__title {
      line-height: 50px;
      height: 50px;
      font-size: 13px;
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

      .is-opened {
        background: #fafbfc;
      }
    }

    .el-menu--popup {
      padding: 0;
      background: #fafbfc;
      border-radius: 1px;
      box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.02);
    }

    .el-menu--popup-right-start {
      margin-left: 0;
      margin-right: 0;
    }
  }
</style>

