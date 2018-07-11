<template>
  <el-container class="bp-layout">
    <el-header class="bp-header" height="50px">
      <header-nav :isCollapsed="isCollapsed"></header-nav>
    </el-header>
    <el-container class="bp-wrap">
      <el-aside class="bp-aside" :width="isCollapsed ? '60px' : '210px'">
        <sider-menu :isCollapsed="isCollapsed"></sider-menu>
      </el-aside>
      <el-main class="bp-main">
        <router-view></router-view>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
  import SiderMenu from '@admin/components/SiderMenu'
  import HeaderNav from '@admin/components/HeaderNav'

  export default {
    components: { HeaderNav, SiderMenu },
    computed: {
      isCollapsed() {
        return this.$store.state.sidebar.collapsed
      }
    }
  }
</script>
<style lang="scss">
  .bp-layout {
    .bp-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
      padding: 0 0 20px 0;
      background: #fff;
      box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.02);
    }

    .bp-wrap {
      padding-top: 50px;
    }

    .bp-aside {
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.01);
      transition: width 0.2s;
      min-height: calc(100vh - 50px);
    }

    .bp-main {
      background: #f3f3f3;
    }
  }
</style>
