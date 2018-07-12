<template>
  <el-container class="bp-layout">
    <el-header class="bp-header" height="50px">
      <header-nav :isCollapsed="isCollapsed"></header-nav>
    </el-header>
    <el-container class="bp-wrap">
      <el-aside class="bp-aside" :width="isCollapsed ? '60px' : '210px'">
        <prefect-scrollbar class="bp-scrollbar">
          <sider-menu class="bp-menu" :isCollapsed="isCollapsed"></sider-menu>
        </prefect-scrollbar>
      </el-aside>
      <el-main :style="{ marginLeft: isCollapsed ? '60px' : '210px' }" class="bp-main">
        <transition name="el-fade-in-linear">
          <router-view></router-view>
        </transition>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
  import SiderMenu from '@admin/components/SiderMenu'
  import HeaderNav from '@admin/components/HeaderNav'
  import PrefectScrollbar from '@core/components/PrefectScrollbar'

  export default {
    components: { PrefectScrollbar, HeaderNav, SiderMenu },
    computed: {
      isCollapsed() {
        return this.$store.state.sidebar.collapsed
      }
    }
  }
</script>
<style lang="scss">
  .bp-layout {
    background: #f4f8fb;
    min-height: 100vh;

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
      position: fixed;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.01);
      transition: width 0.2s;

      .bp-scrollbar {
        height: calc(100vh - 50px);
      }

      .bp-menu {
        min-height: calc(100vh - 50px);
      }
    }
  }
</style>
