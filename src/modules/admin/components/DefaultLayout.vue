<template>
  <el-container class="ag-layout">
    <el-header
      class="ag-header"
      height="50px"
    />
    <el-container class="ag-wrap">
      <el-aside
        class="ag-aside"
        :width="isCollapsed ? '60px' : '200px'"
      >
        <prefect-scrollbar
          :scroll-to="'li.el-menu-item.is-active'"
          :settings="{ suppressScrollX: true }"
          class="bp-scrollbar"
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
import PrefectScrollbar from '@core/components/PrefectScrollbar/index'

export default {
  name: 'DefaultLayout',
  components: { PrefectScrollbar },
  computed: {
  },
  async beforeCreate () {
  }
}
</script>
<style lang="scss">
</style>
