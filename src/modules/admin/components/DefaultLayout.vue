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
        />
      </el-aside>
      <el-main
        :style="{ marginLeft: 1===1 ? '60px' : '200px' }"
        class="ag-main"
      >
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

export default {
  name: 'DefaultLayout',
  components: { PrefectScrollbar, HeaderNav },
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
</style>
