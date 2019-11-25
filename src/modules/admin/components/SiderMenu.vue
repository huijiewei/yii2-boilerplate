<template>
  <el-menu
    :collapse-transition="false"
    :router="true"
    :default-active="getRouteActive"
    :collapse="isCollapsed"
  >
    <template v-for="(menu, index) in getMenus">
      <sider-menu-item
        v-if="!menu.children"
        :key="'m' + 1 + index"
        :menu="menu"
      />
      <sider-menu-sub
        v-else
        :key="'m' + 1 + index"
        :menu="menu"
        :depth="1"
        :index="index"
      />
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
  props: {
    isCollapsed: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    getMenus() {
      return this.$store.getters['auth/getGroupMenus']
    },
    getRouteActive() {
      let matched = this.$route.matched

      for (let i = matched.length - 1; i >= 0; i--) {
        const route = matched[i]

        const find = this.$store.getters['auth/isRouteInMenus'](route.path)

        if (find) {
          return route.path
        }
      }

      return ''
    }
  }
}
</script>
<style lang="scss">
.ag {
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
