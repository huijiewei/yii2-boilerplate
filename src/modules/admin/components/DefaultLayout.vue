<template>
  <el-container class="ag-layout">
    <el-header
      class="ag-header"
      height="50px"
    >
      <header-nav :is-collapsed="isCollapsed" />
    </el-header>
    <el-container class="ag-wrap">
      <el-aside
        class="ag-aside"
        :width="isCollapsed ? '60px' : '200px'"
      >
        <prefect-scrollbar
          :scroll-to="'li.el-menu-item.is-active'"
          :settings="{ suppressScrollX: true }"
          class="ag-scrollbar"
        >
          <sider-menu
            class="ag-menu"
            :is-collapsed="isCollapsed"
          />
        </prefect-scrollbar>
      </el-aside>
      <el-main
        :style="{ marginLeft: isCollapsed ? '60px' : '200px' }"
        class="ag-main"
      >
        <breadcrumb />
        <div class="ag-content">
          <router-view />
        </div>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
import flatry from '@core/utils/flatry'
import PrefectScrollbar from '@core/components/PrefectScrollbar/index'
import HeaderNav from '@admin/components/HeaderNav'
import SiderMenu from '@admin/components/SiderMenu'
import Breadcrumb from '@admin/components/Breadcrumb'

export default {
  name: 'DefaultLayout',
  components: { PrefectScrollbar, HeaderNav, SiderMenu, Breadcrumb },
  computed: {
    isCollapsed () {
      return this.$store.getters.isSidebarCollapsed
    }
  },
  async beforeCreate () {
    if (!this.$store.getters['auth/getCurrentUser']) {
      await flatry(this.$store.dispatch('auth/authentication'))
    }
  }
}
</script>
<style lang="scss">
  @import "../assets/styles/default-layout.scss";
</style>
