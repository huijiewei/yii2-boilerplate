<template>
  <el-menu
    :collapse-transition="false"
    :router="true"
    :default-active="getRouteActive"
    :collapse="isCollapsed"
    background-color="#2c343f"
    text-color="#fff"
    active-text-color="#ffd04b"
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
    SiderMenuItem,
  },
  props: {
    isCollapsed: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    getMenus() {
      return this.$store.getters['auth/getGroupMenus']
    },
    getRouteActive() {
      const paths = this.$route.path
        .split('/')
        .filter((split) => split.length > 0)

      const pathTable = []

      for (let i = paths.length - 1; i >= 0; i--) {
        pathTable.push(paths.slice(0, i + 1))
      }

      for (let i = 0; i < pathTable.length; i++) {
        const url = pathTable[i].join('/')
        const find = this.$store.getters['auth/isRouteInMenus'](url)

        if (find) {
          return '/' + url
        }
      }

      return this.$route.path
    },
  },
}
</script>
<style lang="scss">
.ag {
  .el-menu {
    border-right: none;
  }

  .el-submenu__title i,
  .el-menu-item i {
    color: #ffffff;
  }

  .el-menu-item,
  .el-submenu {
    .ag-icon {
      margin-right: 5px;
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
