<template>
  <el-container class="bp-layout">
    <el-header height="50px">
      <header-nav :isCollapsed="isCollapsed"></header-nav>
    </el-header>
    <el-container>
      <el-aside :width="isCollapsed ? '60px' : '210px'">
        <sider-menu :isCollapsed="isCollapsed"></sider-menu>
      </el-aside>
      <el-main>
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
        return this.$store.state.app.isCollapsed
      }
    }
  }
</script>
<style lang="scss">
  .el-aside {
    border-right: 1px solid #e4e9f0;
    transition: width 0.2s;
  }
</style>
