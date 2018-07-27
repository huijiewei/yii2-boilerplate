<template>
  <el-container class="bp-layout">
    <el-header class="bp-header" height="50px">
      <header-nav :isCollapsed="isCollapsed"></header-nav>
    </el-header>
    <el-container class="bp-wrap">
      <el-aside class="bp-aside" :width="isCollapsed ? '60px' : '200px'">
        <prefect-scrollbar :scroll-to="'li.el-menu-item.is-active'"
                           :settings="{ suppressScrollX: true }"
                           class="bp-scrollbar">
          <sider-menu class="bp-menu" :isCollapsed="isCollapsed"></sider-menu>
        </prefect-scrollbar>
      </el-aside>
      <el-main :style="{ marginLeft: isCollapsed ? '60px' : '200px' }" class="bp-main">
        <breadcrumb></breadcrumb>
        <div class="bp-content">
          <router-view></router-view>
        </div>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
  import SiderMenu from '@admin/components/SiderMenu'
  import HeaderNav from '@admin/components/HeaderNav'
  import PrefectScrollbar from '@core/components/PrefectScrollbar/index'
  import BpIcon from '@core/components/Icon/index'
  import Breadcrumb from '@admin/components/Breadcrumb'
  import flatry from '@admin/utils/flatry'

  export default {
    name: 'DefaultLayout',
    components: { Breadcrumb, BpIcon, PrefectScrollbar, HeaderNav, SiderMenu },
    computed: {
      isCollapsed() {
        return this.$store.getters.isSidebarCollapsed
      }
    },
    async beforeCreate() {
      if (!this.$store.getters['auth/getCurrentUser']) {
        await flatry(this.$store.dispatch('auth/authentication'))
      }
    }
  }
</script>
<style lang="scss">
  @import "../assets/styles/default-layout.scss";
</style>
